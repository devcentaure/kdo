<?php

namespace AppBundle\Controller;

use AppBundle\AppEvent;
use Symfony\Component\HttpFoundation\Request;
use ZIMZIM\ToolsBundle\Controller\MainController;

use AppBundle\Entity\UserKdo;
use AppBundle\Form\UserKdoType;

/**
 * UserKdo controller.
 *
 */
class UserKdoController extends MainController
{

    /**
     * Lists all UserKdo entities.
     *
     */
    public function indexAction()
    {
        $manager = $this->container->get('app_manager_userkdo');
        $data = array(
            'manager' => $manager,
            'dir' => 'AppBundle:UserKdo',
            'show' => 'appbundle_userkdo_show',
            'edit' => 'appbundle_userkdo_edit'
        );

        return $this->gridList($data);
    }

    /**
     * Creates a new UserKdo entity.
     *
     */
    public function createAction(Request $request, $id)
    {
        $manager = $this->container->get('app_manager_userkdo');
        $entity = $manager->createEntity();

        if (isset($id)) {
            $manager2 = $this->container->get('app_manager_kdo');

            $kdo = $manager2->find($id);
            $entity->setKdo($kdo);
        }

        $security = $this->container->get('security.context');

        $form = $this->createCreateForm($entity, $manager);
        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($security->isGranted('LISTKDO_VIEW', $entity->getKdo()->getListKdo()) === false) {
                $this->displayError('app.listkdo.slug.noaccess');

                return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
            }

            $event = $this->container->get('app.event.userkdo');
            $event->setUserKdo($entity);
            $this->container->get('event_dispatcher')->dispatch(AppEvent::UserKdoAdd, $event);
            $this->createSuccess();

            return $this->redirect($this->generateUrl('appbundle_listkdo_slug', array('slug' => $entity->getKdo()->getListkdo()->getSlug())));
        }

        return $this->render(
            'AppBundle:UserKdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a UserKdo entity.
     *
     * @param UserKdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserKdo $entity, $manager)
    {
        $link = $this->generateUrl('appbundle_userkdo_create');
        if($entity->getKdo() !== null){
            $link = $this->generateUrl('appbundle_userkdo_create_kdo', array('id' => $entity->getKdo()->getId()));
        }
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $link,
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
     * Displays a form to create a new UserKdo entity.
     *
     */
    public function newAction()
    {
        $manager = $this->container->get('app_manager_userkdo');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager);

        return $this->render(
            'AppBundle:UserKdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a UserKdo entity.
     *
     */
    public function showAction($id)
    {
        $manager = $this->container->get('app_manager_userkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserKdo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:UserKdo:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing UserKdo entity.
     *
     */
    public function editAction($id)
    {
        $manager = $this->container->get('app_manager_userkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserKdo entity.');
        }

        $security = $this->container->get('security.context');
        if ($security->isGranted('LISTKDO_UPDATE', $entity->getKdo()->getListKdo()) === false) {
            $this->displayError('app.listkdo.slug.noaccess');

            return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
        }

        $editForm = $this->createEditForm($entity, $manager);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:UserKdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a UserKdo entity.
     *
     * @param UserKdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(UserKdo $entity, $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl('appbundle_userkdo_update', array('id' => $entity->getId())),
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
     * Edits an existing UserKdo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->container->get('app_manager_userkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserKdo entity.');
        }

        $security = $this->container->get('security.context');
        if ($security->isGranted('LISTKDO_UPDATE', $entity->getKdo()->getListKdo()) === false) {
            $this->displayError('app.listkdo.slug.noaccess');

            return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $manager);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $event = $this->container->get('app.event.userkdo');
            $event->setUserKdo($entity);
            $this->container->get('event_dispatcher')->dispatch(AppEvent::UserKdoUpdate, $event);
            $this->updateSuccess();


            if($security->isGranted('ROLE_ADMIN') === true){
                return $this->redirect($this->generateUrl('appbundle_userkdo'));
            }else{
                return $this->redirect($this->generateUrl('appbundle_listkdo_slug', array('slug' => $entity->getKdo()->getListkdo()->getSlug())));
            }
        }

        return $this->render(
            'AppBundle:UserKdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a UserKdo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $security = $this->container->get('security.context');

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $manager = $this->container->get('app_manager_userkdo');

            $entity = $manager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserKdo entity.');
            }

            if ($security->isGranted('LISTKDO_DELETE', $entity->getKdo()->getListkdo()) === false) {
                $this->displayError('app.listkdo.slug.noaccess');

                return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
            }

            $event = $this->container->get('app.event.userkdo');
            $event->setUserKdo($entity);
            $this->container->get('event_dispatcher')->dispatch(AppEvent::UserKdoDelete, $event);
            $this->deleteSuccess();

            if($security->isGranted('ROLE_ADMIN') === true){
                return $this->redirect($this->generateUrl('appbundle_userkdo'));
            }else{
                return $this->redirect($this->generateUrl('appbundle_listkdo_slug', array('slug' => $entity->getKdo()->getListkdo()->getSlug())));
            }
        }

        if ($security->isGranted('ROLE_ADMIN')){
            return $this->redirect($this->generateUrl('appbundle_kdo'));
        }

        return $this->redirect($this->generateUrl('appbundle_listkdo_list'));
    }

    /**
     * Creates a form to delete a UserKdo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('appbundle_userkdo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                array('label' => 'button.delete', 'attr' => array('class' => 'tiny button alert'))
            )
            ->getForm();
    }
}
