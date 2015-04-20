<?php

namespace AppBundle\Controller;

use AppBundle\AppEvent;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ListKdo;
use ZIMZIM\ToolsBundle\Controller\MainController;

/**
 * ListKdo controller.
 *
 */
class ListKdoController extends MainController
{

    /**
     * Lists all ListKdo entities.
     *
     */
    public function indexAction()
    {

        $manager = $this->container->get('app_manager_listkdo');
        $data = array(
            'manager' => $manager,
            'dir' => 'AppBundle:ListKdo',
            'show' => 'appbundle_listkdo_show',
            'edit' => 'appbundle_listkdo_edit'
        );

        return $this->gridList($data);
    }

    /**
     * Creates a new ListKdo entity.
     *
     */
    public function createAction(Request $request)
    {
        $manager = $this->container->get('app_manager_listkdo');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $event = $this->container->get('app.event.listkdo');
            $event->setListKdo($entity);
            $this->container->get('event_dispatcher')->dispatch(AppEvent::ListKdoAdd, $event);
            $this->createSuccess();

            $security = $this->container->get('security.context');

            if ($security->isGranted('ROLE_ADMIN') === true) {
                return $this->redirect(
                    $this->generateUrl('appbundle_listkdo_show', array('id' => $event->getListKdo()->getId()))
                );
            }

            return $this->redirect(
                $this->generateUrl('appbundle_listkdo_slug', array('slug' => $event->getListKdo()->getSlug()))
            );
        }

        return $this->render(
            'AppBundle:ListKdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a ListKdo entity.
     *
     * @param ListKdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ListKdo $entity, $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl('appbundle_listkdo_create'),
                'method' => 'POST',
            )
        );

        $form->add(
            'submit',
            'submit',
            array('label' => 'button.validate', 'attr' => array('class' => 'tiny button success'))
        );

        return $form;
    }

    /**
     * Displays a form to create a new ListKdo entity.
     *
     */
    public function newAction()
    {
        $manager = $this->container->get('app_manager_listkdo');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager);

        return $this->render(
            'AppBundle:ListKdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a ListKdo entity.
     *
     */
    public function showAction($id)
    {
        $manager = $this->container->get('app_manager_listkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListKdo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:ListKdo:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing ListKdo entity.
     *
     */
    public function editAction($id)
    {
        $manager = $this->container->get('app_manager_listkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListKdo entity.');
        }

        $security = $this->container->get('security.context');
        if ($security->isGranted('LISTKDO_UPDATE', $entity) === false) {
            $this->displayError('app.listkdo.slug.noaccess');

            return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
        }

        $editForm = $this->createEditForm($entity, $manager);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:ListKdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a ListKdo entity.
     *
     * @param ListKdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ListKdo $entity, $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl('appbundle_listkdo_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add(
            'submit',
            'submit',
            array('label' => 'button.validate', 'attr' => array('class' => 'tiny button success'))
        );

        return $form;
    }

    /**
     * Edits an existing ListKdo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {

        $manager = $this->container->get('app_manager_listkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListKdo entity.');
        }

        $security = $this->container->get('security.context');
        if ($security->isGranted('LISTKDO_UPDATE', $entity) === false) {
            $this->displayError('app.listkdo.slug.noaccess');

            return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $manager);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $event = $this->container->get('app.event.listkdo');
            $event->setListKdo($entity);
            $this->container->get('event_dispatcher')->dispatch(AppEvent::ListKdoUpdate, $event);
            $this->updateSuccess();

            return $this->redirect($this->generateUrl('appbundle_listkdo_edit', array('id' => $id)));
        }

        return $this->render(
            'AppBundle:ListKdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a ListKdo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $security = $this->container->get('security.context');

        if ($form->isValid()) {

            $manager = $this->container->get('app_manager_listkdo');

            $entity = $manager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ListKdo entity.');
            }

            if ($security->isGranted('LISTKDO_DELETE', $entity) === false) {
                $this->displayError('app.listkdo.slug.noaccess');

                return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
            }

            $event = $this->container->get('app.event.listkdo');
            $event->setListKdo($entity);
            $this->container->get('event_dispatcher')->dispatch(AppEvent::ListKdoDelete, $event);
            $this->deleteSuccess();
        }

        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('appbundle_listkdo'));
        }

        return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
    }

    /**
     * Creates a form to delete a ListKdo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('appbundle_listkdo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                array('label' => 'button.delete', 'attr' => array('class' => 'tiny button alert'))
            )
            ->getForm();
    }


    public function listAction()
    {

        $manager = $this->container->get('app_manager_listkdo');

        $entities = $manager->getRepository()->getListByDate(new \DateTime('now'));

        return $this->render(
            'AppBundle:ListKdo:list.html.twig',
            array(
                'entities' => $entities
            )
        );

    }

    public function slugAction($slug)
    {

        $security = $this->container->get('security.context');

        $manager = $this->container->get('app_manager_listkdo');

        $entity = $manager->getBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListKdo entity.');
        }

        if ($security->isGranted('LISTKDO_VIEW', $entity) === false) {
            $this->displayError('app.listkdo.slug.noaccess');

            return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
        }

        return $this->render(
            'AppBundle:ListKdo:slug.html.twig',
            array(
                'entity' => $entity
            )
        );
    }


    public function getAccessListKdoAction(Request $request, $id)
    {

        $security = $this->container->get('security.context');

        $manager = $this->container->get('app_manager_listkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListKdo entity.');
        }

        if ($security->isGranted('LISTKDO_VIEW', $entity) === true) {
            $this->displayError('app.listkdo.slug.alwaysaccess');

            return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
        }

        $form = $this->createGetAccessForm($entity->getId());

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $datas = $form->getData();

                $pass = null;
                if (isset($datas['listkdo_pass'])) {
                    $pass = $datas['listkdo_pass'];
                }

                if ($pass === $entity->getPassword()) {


                    $em = $this->getDoctrine()->getManager();
                    $userlistkdo = $this->container->get('app_entity_userlistkdo');
                    $userlistkdo->setUser($security->getToken()->getUser());
                    $userlistkdo->setListKdo($entity);
                    $em->persist($userlistkdo);
                    $em->flush();

                    $this->displaySuccess('app.listkdo.getaccess.rightpass');

                    return $this->redirect(
                        $this->generateUrl('appbundle_listkdo_slug', array('slug' => $entity->getSlug()))
                    );
                } else {
                    $this->displayError('app.listkdo.getaccess.wrongpass');
                }
            }
        }

        return $this->render(
            'AppBundle:ListKdo:getaccess.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView()
            )
        );

    }

    private function createGetAccessForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('appbundle_listkdo_getaccess', array('id' => $id)))
            ->setMethod('POST')
            ->add(
                'listkdo_pass',
                'password',
                array('label' => 'entity.listkdo.password')
            )
            ->add(
                'submit',
                'submit',
                array('label' => 'button.validate', 'attr' => array('class' => 'tiny button success'))
            )
            ->getForm();
    }
}
