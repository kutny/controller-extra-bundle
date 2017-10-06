<?php

namespace Kutny\ControllerExtraBundle;

class AnnotationList
{
    private $annotations;

    /**
     * @param $annotations
     */
    public function __construct(array $annotations)
    {
        $this->annotations = $annotations;
    }

    public function hasAnnotation($className)
    {
        foreach ($this->annotations as $annotation) {
            $annotationClass = get_class($annotation);

            if ($annotationClass === $className) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $name
     */
    public function getAnnotation($className)
    {
        foreach ($this->annotations as $annotation) {
            $annotationClass = get_class($annotation);

            if ($annotationClass === $className) {
                return $annotation;
            }
        }

        return null;
    }

    /**
     * @param $name
     */
    public function getAnnotations($className)
    {
        return array_filter($this->annotations, function ($annotation) use ($className) {
            return get_class($annotation) === $className;
        });
    }
}
