<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ZIMZIM\ToolsBundle\Controller\MainController;

use AppBundle\Entity\UserListKdo;
use AppBundle\Form\UserListKdoType;

/**
 * UserListKdo controller.
 *
 */
class UserListKdoController extends MainController
{

    /**
     * Lists all UserListKdo entities.
     *
     */
    public function indexAction()
    {
        $manager = $this->container->get('app_manager_userlistkdo');
        $data = array(
            'manager' => $manager,
            'dir' => 'AppBundle:UserListKdo',
            'show' => 'appbundle_userlistkdo_show',
            'edit' => 'appbundle_userlistkdo_edit'
        );

        return $this->gridList($data);
    }

    /**
     * Creates a new UserListKdo entity.
     *
     */
    public function createAction(Request $request)
    {
        $manager = $this->container->get('app_manager_userlistkdo');
        $entity = $manager->createEntity();

        $form = $this->createCreateForm($entity, $manager);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->createSuccess();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('appbundle_userlistkdo_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'AppBundle:UserListKdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a UserListKdo entity.
     *
     * @param UserListKdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserListKdo $entity, $manager)
    {
        $form = $this->createForm(
            'appbundle_userlistkdo_formtype',
            $entity,
            array(
                'action' => $this->generateUrl('appbundle_userlistkdo_create'),
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
     * Displays a form to create a new UserListKdo entity.
     *
     */
    public function newAction()
    {
        $manager = $this->container->get('app_manager_userlistkdo');
        $entity = $manager->createEntity();

        $form = $this->createCreateForm($entity, $manager);

        return $this->render(
            'AppBundle:UserListKdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a UserListKdo entity.
     *
     */
    public function showAction($id)
    {

        $manager = $this->container->get('app_manager_userlistkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserListKdo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:UserListKdo:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing UserListKdo entity.
     *
     */
    public function editAction($id)
    {
        $manager = $this->container->get('app_manager_userlistkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserListKdo entity.');
        }

        $editForm = $this->createEditForm($entity, $manager);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:UserListKdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a UserListKdo entity.
     *
     * @param UserListKdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(UserListKdo $entity, $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl('appbundle_userlistkdo_update', array('id' => $entity->getId())),
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
     * Edits an existing UserListKdo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->container->get('app_manager_userlistkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserListKdo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $manager);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->updateSuccess();
            $em->flush();

            return $this->redirect($this->generateUrl('appbundle_userlistkdo_edit', array('id' => $id)));
        }

        return $this->render(
            'AppBundle:UserListKdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a UserListKdo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:UserListKdo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserListKdo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->deleteSuccess();
        }

        return $this->redirect($this->generateUrl('appbundle_userlistkdo'));
    }

    /**
     * Creates a form to delete a UserListKdo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('appbundle_userlistkdo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                array('label' => 'button.delete', 'attr' => array('class' => 'tiny button alert'))
            )
            ->getForm();
    }

}
