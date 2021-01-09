<?php


namespace App\EventSubscriber;


use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ProductSubscriber implements \Doctrine\Common\EventSubscriber
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {

        $this->mailer = $mailer;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
          Events::postPersist
        ];
    }

    /**
     * @Param LifecycleEventArgs $args
    */

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->sendNotifyMail($args);
    }

    public function sendNotifyMail(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product)
        {
            return ;
        }

        $email = (new Email())
            ->from('noreply@eshop.com')
            ->to('marketing@eshop.com')
            ->subject("Création d'un nouveau produit")
            ->html("<p>Création de produit</p>")
        ;

        $this->mailer->send($email);
    }
}