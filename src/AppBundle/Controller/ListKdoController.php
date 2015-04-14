<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Centaure\Controller\CentaureController;

use AppBundle\Entity\ListKdo;
use AppBundle\Form\ListKdoType;
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

        $this->gridList($data);


        return $this->grid->getGridResponse('AppBundle:ListKdo:index.html.twig');
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

            $this->createSuccess();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('appbundle_listkdo_show', array('id' => $entity->getId())));
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
        $em = $this->getDoctrine()->getManager();

        $manager = $this->container->get('app_manager_listkdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListKdo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $manager);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->updateSuccess();
            $em->flush();

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

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $manager = $this->container->get('app_manager_listkdo');

            $entity = $manager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ListKdo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->deleteSuccess();
        }

        return $this->redirect($this->generateUrl('appbundle_listkdo'));
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


    public function listAction(){

        $manager = $this->container->get('app_manager_listkdo');

        $entities = $manager->getRepository()->getListByDate(new \DateTime('now'));

        return $this->render(
            'AppBundle:ListKdo:list.html.twig',
            array(
                'entities' => $entities
            )
        );

    }

    public function slugAction($slug){

        $manager = $this->container->get('app_manager_listkdo');

        $entity = $manager->getBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListKdo entity.');
        }

        return $this->render(
            'AppBundle:ListKdo:slug.html.twig',
            array(
                'entity' => $entity
            )
        );

    }

}
