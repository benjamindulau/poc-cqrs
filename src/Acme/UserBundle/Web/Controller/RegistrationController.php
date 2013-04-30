<?php

namespace Acme\UserBundle\Web\Controller;

use Acme\CommonBundle\Web\Controller\Controller;
use Acme\UserBundle\Web\Command\FormType\RegisterCommandFormType;
use Acme\UserBundle\Web\Command\RegisterCommand;
use Acme\UserBundle\Web\Command\VerifyEmailCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $registerCommand = new RegisterCommand();
        $form = $this->createForm(new RegisterCommandFormType(), $registerCommand);

        if ('POST' == $request->getMethod()) {
            $form->bind($request);

            // TODO: create command validation constraints (pre-validation)
            if ($form->isValid()) {
                /*
                 * TODO:
                 *
                 * Since commands doesn't return any data,
                 * how to send messages back to the user ?
                 * Such as success or failure messages ?
                 */
                $this->getCommandBus()->handle($registerCommand);

                return $this->redirect($this->generateUrl('user_list'));
            }
        }

        return $this->render('AcmeUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
            'translation_domain' => 'AcmeUserBundle',
        ));
    }

    /**
     * @param Request $request
     * @param mixed   $id
     * @return Response
     */
    public function verifyEmailAction(Request $request, $id)
    {
        $userDto = $this->getUserDataRepository()->getById($id);

        $verifyEmailCommand = new VerifyEmailCommand(array(
            'id' => $userDto->id,
            'email' => $userDto->email,
        ));

        if ('POST' == $request->getMethod()) {
            /*
             * TODO: validate command data
             */
            $this->getCommandBus()->handle($verifyEmailCommand);
        }

        return $this->render('AcmeUserBundle:Registration:verify_email.html.twig', array(
            'user' => $userDto,
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