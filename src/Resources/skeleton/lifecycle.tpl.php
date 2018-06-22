<?php
    function camelize(string $text) {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) { return ('.' === $match[1] ? '_' : '').strtoupper($match[2]); }, $text);
    }
?>
<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use Symfony\Component\HttpFoundation\Response;
use TBoileau\LifecycleBundle\EventSubscriber\LifecycleSubscriber;

class <?= $class_name ?> extends LifecycleSubscriber
{
    /**
     * @return array
     */
    public static function getSubscribedStates(): array
    {
        return [
<?php foreach($states as $state) { ?>
            "<?= strtoupper($state) ?>" => "<?= lcfirst(camelize($state)) ?>",
<?php }?>
        ];
    }

<?php foreach($states as $state) { ?>
    /**
     * @param $object
     * @return Response
     */
    public function <?= lcfirst(camelize($state)) ?>($object): Response
    {
        // PUT YOUR LOGIC IN HERE
    }
<?php }?>
}