<?php
	class Router {
		private $routes = [];

		public function addRoute($method, $path, $controllerMethod) {
			$this->routes[] = [
				'method' => strtoupper($method),
				'path' => $path,
				'controllerMethod' => $controllerMethod
			];
		}

		public function dispatch() {
			$method = strtoupper($_SERVER['REQUEST_METHOD']);
			$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			
			foreach ($this->routes as $route) {
				if ($method === $route['method'] && $path === $route['path']) {
					list($controller, $method) = explode('@', $route['controllerMethod']);
					$this->callControllerMethod($controller, $method);
					return;
				}
			}

			$this->error404();
		}

		private function callControllerMethod($controller, $method) {
			$controllerClass = $controller . 'Controller';
			$controllerFile = '../controllers/' . $controllerClass . '.php';

			if (file_exists($controllerFile)) {
				require_once $controllerFile;
				$controllerInstance = new $controllerClass();

				if (method_exists($controllerInstance, $method)) {
					$controllerInstance->$method();
				} else {
					$this->error404();
				}
			} else {
				$this->error404();
			}
		}
		private function error404() {
			echo "404 - Page Not Found.";
		}
	}

	$router = new Router();

	$router->addRoute('GET', '/orgdon-v2/auth/login', 'Login@index');
	$router->addRoute('POST', '/orgdon-v2/auth/login', 'Login@login');
	$router->addRoute('GET', '/orgdon-v2/auth/register', 'Register@index');
	$router->addRoute('POST', '/orgdon-v2/auth/register', 'Register@register');
	$router->addRoute('GET', '/orgdon-v2/dashboard', 'Dashboard@roleBasedIndex');
	$router->addRoute('GET', '/orgdon-v2/logout', 'Dashboard@logout');
	$router->addRoute('POST', '/orgdon-v2/complete-profile', 'Dashboard@completeProfile');
	$router->addRoute('POST', '/orgdon-v2/register-donor', 'Dashboard@registerDonor');
	$router->addRoute('POST', '/orgdon-v2/update-health', 'Dashboard@updateHealth');
	$router->addRoute('POST', '/orgdon-v2/doctor/update-fit-status', 'Dashboard@updateFitStatus');
	$router->addRoute('POST', '/orgdon-v2/doctor/update-availability', 'Dashboard@updateAvailability');
	$router->addRoute('GET', '/orgdon-v2/api/organs', 'Api@organs');
	$router->addRoute('GET', '/orgdon-v2/api/organ-details', 'Api@organDetails');
	$router->addRoute('POST', '/orgdon-v2/api/update-donation-status', 'Api@updateDonationStatus');

	$router->dispatch();
?>