<?php

namespace Acme\UserBundle\Web\Controller;

use Acme\CommonBundle\Web\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewController extends Controller
{
    /**
     * @param Request $request
     * @param mixed   $id
     * @return Response
     */
    public function viewAction(Request $request, $id)
    {
        $user = $this->getUserDataRepository()->getById($id);

        return $this->render('AcmeUserBundle:View:view.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $users = $this->getUserDataRepository()->getAll();

        return $this->render('AcmeUserBundle:View:list.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @return \Acme\UserBundle\Data\User\UserDataRepositoryInterface
     */
    public function getUserDataRepository()
    {
        return $this->get('acme_user.data.user.user_repository');
    }
}