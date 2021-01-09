<?php


namespace App\EventSubscriber;


use App\Entity\User;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSubscriber implements \Doctrine\Common\EventSubscriber
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            Events::prePersist
        ];
    }

    /**
     * @Param LifecycleEventArgs $args
    */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->encodePassword($args);
    }

    public function encodePassword(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if(!$entity instanceof User)
        {
            return ;
        }

       $entity->setPassword(
         $this->encoder->encodePassword($entity, $entity->getPassword())
       );

    }
}