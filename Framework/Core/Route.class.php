<?php
	
	namespace Core;
	class Route {
	   	protected static $base_path;
	   	protected static $request_uri;
	   	protected static $request_method;
	   	protected static $http_methods = array('get', 'post', 'put', 'patch', 'delete');
	   	protected static $wild_cards = array('int' => '/^[0-9]+$/', 'any' => '/^[0-9A-Za-z]+$/');
	   	public static $Routes	=	[];
	   
		public static function run($base_path = '') {
			self::$base_path = $base_path;
	
			// Remove query string and trim trailing slash
			self::$request_uri = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
			self::$request_method = self::_determine_http_method();
		}
	
	   	private static function _determine_http_method() {
			$method = strtolower($_SERVER['REQUEST_METHOD']);
	
			if (in_array($method, self::$http_methods)) return $method;
			return 'get';
	   }
	
	   	public static function respond($method, $route, $callable) {
			$method = strtolower($method);
	
			if ($route == '/'){
				$route = self::$base_path;
			}
			else {
				$route = self::$base_path . $route;
			}
	
			$matches = self::_match_wild_cards($route);
	
			if (is_array($matches) && $method == self::$request_method) {
				// Routes match and request method matches
				self::$Routes[] = $route;
				call_user_func_array($callable, $matches);
			}
		}
	
	   	private static function _match_wild_cards($route) {
			$variables = array();
	
			$exp_request = explode('/', self::$request_uri);
			$exp_route = explode('/', $route);
	
			if (count($exp_request) == count($exp_route)) {
				foreach ($exp_route as $key => $value) {
					if ($value == $exp_request[$key]) {
						continue;   // So far the routes are matching
					}
					elseif ($value[0] == '(' && substr($value, -1) == ')') {
						$strip = str_replace(array('(', ')'), '', $value);
						$exp = explode(':', $strip);
	
						if (array_key_exists($exp[0], self::$wild_cards)) {
							$pattern = self::$wild_cards[$exp[0]];
	
							if (preg_match($pattern, $exp_request[$key])) {
								if (isset($exp[1])) {
									$variables[$exp[1]] = $exp_request[$key];
								}
								continue;   // We have a matching pattern
							}
						}
					}
					return false;  // There is a mis-match
				}
				return $variables;   // All segments match
			}
			return false;  // Catch anything else
		}
		
		public static function checkRoute(){
			$uri = $_SERVER['REQUEST_URI'];
			$uri = rtrim($uri, '/');
			$ur = substr($uri, 0, strrpos( $uri, '/'));
			#var_dump($ur);
			
			if(isset(self::$Routes[0])){
				$variable = substr(self::$Routes[0], 0, strpos(self::$Routes[0], "("));
				$xx = rtrim($variable, '/');
				$do = $fruits_ar = explode(',', $xx);
				self::$Routes	=	$do;
				#var_dump($do);
			}
			if(!in_array(explode('?',$ur)[0],self::$Routes)){
				die("Invalid route.");
			}
		}
	}