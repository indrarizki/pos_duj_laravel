<?php
namespace App;

use App\Customer;
class flexcodesdk
{
    public static function getDevice()
    {
        $data['device_name']        =  env('devicee');
        $data['serial_number']      =  env('K520E05351');
        $data['verification_code']  =  env('7C02881AF25A05E');
        $data['activation_code']    =  env('NGBAC42FB33D7B948BF05LXC');
        $data['verification_key']   =  env('452738E9D0C61FC209C38DF14F85A090');

        return response()->json($data);
    }

    public function registerUrl($user_id)
    {
        return  $user_id . ';SecurityKey;15;'.url('fingerprints/register/' . $user_id).';' . url('fingerprints/ac');
    }

    public function getDeviceBySn($sn)
    {
        $devices = Config::get('flexcodesdk', 'devices');
        foreach ($devices as $device) {
            if($device['sn'] === $sn){
                return $device;
            }
        }
        return false;
    }

    public function decodeRegistrationData($serialized_data)
    {   
        @list($vStamp, $sn, $user_id, $regTemp) = explode(";", $serialized_data);
        if( !isset($vStamp) || !isset($sn) || !isset($user_id) || !isset($regTemp)){
            return array();
        }
        
        return array(
            'vStamp'     =>  $vStamp,
            'sn'         =>  $sn,
            'user_id'    =>  $user_id,
            'regTemp'    =>  $regTemp,
        );
        
    }

    public function isValidRegistration($user, $data)
    {
        
        if(!empty($user->fingerprints) || $user->id !== $data['user_id']){
            return false;
        }
        
        $device = flexcodesdk::getDeviceBySn($data['sn']);
        
        $salt = md5($device['ac'].$device['vkey'].$data['regTemp'].$data['sn'].$data['user_id']);
        return (strtoupper($data['vStamp']) == strtoupper($salt)) ? true : false;
    }

    public function register($id, $serialized_data)
    {
        $user = Customer::find($id);

        if ($user == NULL) {
            $result['message'] = 'User not found';
            return $result;
        }else{
            $data = explode(";", $serialized_data);

            if(empty($data[3])) {
                $result['message'] = 'Error decoding fingerprint data';
                return $result;
            }else{
                $update['fingerprints'] = $data[3];
                $user->update($update);

                $result['message'] = 'Fingerprints successfully registered';
                return $result;
            }
        }

        
    }

    public function verificationUrl($user, $extra = array())
    {
        $query_string = http_build_query($extra);
        return $user->id . ";". $user->fingerprints.";SecurityKey;". '15' .";". url('fingerprints/verify/' . $user->id . '?' . $query_string) .";". url('fingerprints/ac');
    }

    public function verify($id, $serialized_data)
    {
        $verified = false;
        $message = '';
        try{
            $user = \App\Pengguna::findOrFail($id);
        }
        catch(Exception $e){
            $message = 'User not found';
            $result = array(
                'verified' => $verified,
                'user' => null,
                'message' => $message,
            );
            return $result;
        }
        @list($user_id, $vStamp, $time, $sn) = explode(";", $serialized_data);
        if( !isset($user_id) || !isset($vStamp) || !isset($time) || !isset($sn)){
            $message = 'Incorrect fingerprint data';
            $result = array(
                'verified' => $verified,
                'user' => $user,
                'message' => $message,
            );
            return $result;
        }
        
        if($user->id != $user_id){
            $message =  'User mismatch';
            $result = array(
                'verified' => $verified,
                'user' => $user,
                'message' => $message,
            );
            return $result;
        }
        if(empty($user->fingerprints)){
            $message =  'Fingerprints unregistered';
            $result = array(
                'verified' => $verified,
                'user' => $user,
                'message' => $message,
            );
            return $result;
        }
        
        $fingerData = $user->fingerprints;
        $device     = flexcodesdk::getDeviceBySn($sn);
            
        $salt = md5($sn.$fingerData.$device['vc'].$time.$user_id.$device['vkey']);
        
        if(strtoupper($vStamp) == strtoupper($salt)){
            $result = array(
                'verified' => true,
                'user' => $user,
                'message' => 'Verication success',
            );
            return $result;
        }
        $result = array(
            'user' => $user,
            'message' => 'Fingerprint mismatch',
        );
        return $result;
    }

    public static function getRegistrationLink($id)
    {
        return 'finspot:FingerspotReg;' . base64_encode(url('fingerprints/register/' . $id));
    }

    public static function customRegistrationLink($id) {
         return 'finspot:FingerspotReg;'.  base64_encode(url('register/' . $id));
        //  return test( 'finspot:FingerspotReg;'.  base64_encode( $id));
    }

    public function test($aaa)
    {
        $result = flexcodesdk::register($id, $request->input('RegTemp'));
        $response = Event::fire('fingerprints.register', array($result));
    }

    public function getVerificationLink($id, $extras = array('action' => 'login'))
    {
        // retu rn 'finspot:FingerspotVer;' . base64_encode(url('fingerprints/verify/'));
         $url = url('fingerprints/verify/' . $id . '?' . http_build_query($extras));
        return 'finspot:FingerspotVer;' . base64_encode($url);
    }
}

?>