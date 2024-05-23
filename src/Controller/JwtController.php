<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * JWT Controller
 */
class JwtController extends AbstractController
{

	/**
	 * Authenticate a user from the request and return a JWT (Json Web Token)
	 *
	 * @param Request $request
	 * @param JWTTokenManagerInterface $JWTManager
	 * @return JsonResponse
	 */
	#[Route("/api/login_check", methods:["POST"], name:"login_check")]
	public function getTokenUser(Request $request, UserPasswordHasherInterface $hasher, JWTTokenManagerInterface $JWTManager,UserRepository $userRepository)
	{
		$request = $this->transformJsonBody($request);
		$username = $request->get('username');
		$password = $request->get('password');
		if (empty($username) || empty($password)) {
			return $this->respondWithError('Api token: Missing credentials');
		}

		// Get the user
		
		/** @var UserRepository $userRep */
		$userRepository->getRepository(User::class);
		/** @var User $user */
		$user = $userRepository->findOneByUsername($username);
		if (!$user) {
			return $this->respondWithError('Api token: Incorrect user username');
		}

		$isValid = $hasher->isPasswordValid($user, $password);
		if (!$isValid) {
			return $this->respondWithError('Api token: Incorrect password');
		}

		return new JsonResponse([
			'token' => $JWTManager->create($user)
		]);
	}

	/**
	 * Get JSON payloads in POST request
	 */
	private function transformJsonBody(Request $request): Request
	{
		$data = json_decode($request->getContent(), true);

		if ($data === null) {
			return $request;
		}

		$request->request->replace($data);

		return $request;
	}

	/**
	 * Sets an error message and returns a JSON response
	 *
	 * @param string $errors
	 * @param $headers
	 * @return JsonResponse
	 */
	private function respondWithError(string $error)
	{
		$statusCode = 422;
		$headers = [];

		$data = [
			'status' => $statusCode,
			'error' => $error
		];

		return new JsonResponse($data, $statusCode, $headers);
	}
}
