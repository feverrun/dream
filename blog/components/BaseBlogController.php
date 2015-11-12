<?php
namespace blog\components;

use Yii;
use \common\models\user\User;

class BaseBlogController extends \common\components\BaseWebController{

    public $auth_cookie_name = "m_vincentguo";
    public  $salt = "cr5s6fwPKgKrSvpTNd971ea8fbc47";
    public $current_user = null;

    public function checkLoginStatus(){
        $auth_cookie = $this->getCookie($this->auth_cookie_name);
        $login_status = false;
        if( $auth_cookie ){
            list($auth_token,$uid) = explode("#",$auth_cookie);
            if( $auth_token && $uid ){
                $user_info = User::findOne(['uid' => $uid]);
                $check_token = $this->geneAuthToken($user_info['uid'],$user_info['nickname']);
                if( $user_info && $auth_token == $check_token ){
                    $login_status = true;
                    $this->current_user = $user_info;
                }
            }
        }
        return $login_status;
    }

    public  function createLoginStatus($user_info){
        $auth_token = $this->geneAuthToken($user_info['uid'],$user_info['nickname']);
        $this->setCookie($this->auth_cookie_name,$auth_token."#".$user_info['uid']);
    }

    public  function removeAuthToken(){
        $this->removeCookie($this->auth_cookie_name);
    }

    public function geneAuthToken($uid,$nickname){
        return md5($this->salt."-{$uid}-{$nickname}");
    }
}