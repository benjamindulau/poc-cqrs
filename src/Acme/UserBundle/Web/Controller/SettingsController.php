<?php

namespace Acme\UserBundle\Web\Controller;

use Acme\CommonBundle\Web\Controller\Controller;
use Acme\UserBundle\Web\Command\ChangeEmailCommand;
use Acme\UserBundle\Web\Command\FormType\ChangeEmailCommandFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @param mixed   $id
     * @return Response
     */
    public function changeEmailAction(Request $request, $id)
    {
        $userDto = $this->getUserDataRepository()->getById($id);

        $changeEmailCommand = new ChangeEmailCommand(array(
            'id' => $userDto->id,
            'email' => $userDto->email,
        ));

        $form = $this->createForm(new ChangeEmailCommandFormType(), $changeEmailCommand);

        if ('POST' == $request->getMethod() && $form->isValid()) {
            /*
             * TODO:
             *
             * Since commands doesn't return any data,
             * how to send messages back to the user ?
             * Such as success or failure messages ?
             */
            $this->getCommandBus()->handle($changeEmailCommand);
        }

        return $this->render('AcmeUserBundle:Settings:change_email.html.twig', array(
            'form' => $form->createView(),
            'user' => $userDto,
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