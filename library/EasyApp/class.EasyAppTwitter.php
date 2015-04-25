<?


class EasyAppTwitter{

	private $user_id;
	private $token;	
	private $secret;
	private $screenname;
	private $avatar;
	
	public function __construct($twitter_info){
		$this->user_id = $twitter_info['id'];
		$this->token = $twitter_info['oauth_token'];
		$this->secret = $twitter_info['oauth_token_secret'];
		$this->screenname = $twitter_info['screen_name'];
		if(isset($twitter_info['avatar'])){
			$this->avatar = $twitter_info['avatar'];
		}
		$this->cb = new \Codebird\Codebird;
	    $this->cb->setToken($this->token, $this->secret);
	}
	
	
	public function screenname(){
		return $this->screenname;
	}
	
	public function avatar(){
		return $this->avatar;
	}
	
	public function userId(){
		return $this->user_id;
	}
		
	public function fetchSomeTwitterInfo(){
		$reply = $this->cb->account_verifyCredentials();
		return $reply;
	}
	
	public function followersFor($username, $next_cursor=-1){
		$output = array();
        $results = (array) $this->cb->followers_list(array("screen_name"=>$username,"count"=>200,"cursor"=>$next_cursor,"skip_status" => true));
        if(!isset($results['errors'])){
            foreach($results['users'] as $id){
                $output[]=$id;
            }
			$next_cursor = $results['next_cursor_str'];
			if($next_cursor){
				$output["next_cursor"] = $next_cursor;
			}
        }else{
            $next_cursor = false;
            $output["error"] = $results['errors'][0];
        }
		return $output;
	}
	
	public function profileFor($username){
		$next_cursor = -1; 
		$output = array();
        $result = (array) $this->cb->users_lookup(array("screen_name"=>$username));
        if(!isset($result['errors'])){
            $output = $result[0];
        }else{
	        $output["error"] = true;
        }
		return (array)$output;
	}
	
	public function follow($username){
		$output = array();
        $result = (array) $this->cb->friendships_create(array("screen_name"=>$username, "follow" => true));
        if(!isset($result['errors'])){
            $output = $result[0];
        }else{
	        $output["error"] = true;
        }
		return (array)$output;
	}
	
	public function unfollow($username){
		$output = array();
        $result = (array) $this->cb->friendships_destroy(array("screen_name"=>$username));
        if(!isset($result['errors'])){
            $output = $result[0];
        }else{
	        $output["error"] = true;
        }
		return (array)$output;
	}
	
	public function connectionStatus($username){
		$output = array();
        $result = (array) $this->cb->friendships_lookup(array("screen_name"=>$username, "follow" => true));
        if(!isset($result['errors'])){
	        $info = (array)$result[0];
            $output = $info["connections"];
        }else{
	        $output["error"] = true;
        }
		return (array)$output;
	}
}





?>