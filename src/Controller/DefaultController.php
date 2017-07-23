<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:42
 */

namespace Controller;

use Entity\User;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($loop)
    {
        $nombres = [];
        for($i=1;$i<=$loop;$i++)
        {
            $nombres[] = $i;
        }
        return $this->render("index.html.twig", ["nombres" => $nombres]);
    }

    public function testAction(Request $request)
    {
        if($request->getMethod() == "POST"){
            $user = new User();
            $user->setPassword($request->request->get("password"));
            $user->setUsername($request->request->get("username"));
            $user->setEmail($request->request->get("email"));
            $user->setFirstname($request->request->get("firstname"));
            $user->setLastname($request->request->get("lastname"));
            $this->getDoctrine()->persist($user);
            $this->getDoctrine()->flush();
        }

        $users = $this->getDoctrine()->getRepository("Entity\User")->findAll();

        $user = $this->getDoctrine()->getRepository("Entity\User")->find(1);

        return $this->render("test.html.twig", ["users" => $users,"user"=>$user]);
    }
}