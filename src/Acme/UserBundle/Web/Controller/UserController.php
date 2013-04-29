<?php

namespace Acme\UserBundle\Web\Controller;

use Acme\CommonBundle\Web\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @param mixed   $id
     * @return Response
     */
    public function viewAction(Request $request, $id)
    {
        $user = $this->getUserDataRepository()->getById($id);

        $this->render('AcmeUserBundle:User:view.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @return \Acme\UserBundle\Data\User\UserDataRepositoryInterface
     */
    public function getUserDataRepository()
    {
        return $this->get('acme_user.data.user.repository');
    }
}