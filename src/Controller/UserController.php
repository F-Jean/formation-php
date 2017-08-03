<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 03/08/17
 * Time: 17:01
 */

namespace Controller;

use Entity\User;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package Controller
 */
class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        if($request->getMethod() == "POST"){
            $this->get("session_manager")->set($request->request->all());
            return $this->redirect("index");
        }
        return $this->render("user/login.html.twig");
    }

    public function logoutAction(Request $request)
    {
        $this->get("session_manager")->clear();
        return $this->redirect("index");
    }

    public function registerAction(Request $request)
    {
        if($request->getMethod() == "POST"){
            $user = new User();
            $user->setFirstName($request->request->get("first_name"));
            $user->setLastName($request->request->get("last_name"));
            $user->setEmail($request->request->get("email"));
            $user->setPassword(sha1($request->request->get("password")));
            $this->getDoctrine()->persist($user);
            $this->getDoctrine()->flush();
            return $this->redirect("user_login");
        }
        return $this->render("user/register.html.twig");
    }
}