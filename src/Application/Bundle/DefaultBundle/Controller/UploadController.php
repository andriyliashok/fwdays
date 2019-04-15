<?php

namespace Application\Bundle\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UploadController.
 */
class UploadController extends Controller
{
    /**
     * Upload image (for markitup plugin).
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/admin/text-area/uploadImage", name="text_area_upload_image")
     *
     * @Method({"POST"})
     */
    public function uploadImageAction(Request $request)
    {
        /** @var $file \Symfony\Component\HttpFoundation\File\UploadedFile|null */
        $file = $request->files->get('upload_file');

        $fileConstraint = new Collection(
            [
                 'file' => [
                     new NotBlank(),
                     new Image(),
                 ],
            ]
        );

        // Validate
        /** @var $errors \Symfony\Component\Validator\ConstraintViolationList */
        $errors = $this->get('validator')->validateValue(array('file' => $file), $fileConstraint);
        if ($errors->count() > 0) {
            return new JsonResponse(['msg' => 'Your file is not valid!'], 400);
        }

        list($width, $height) = getimagesize($file);
        $uploadDir = $this->container->getParameter('upload_dir');

        // Move uploaded file
        $newFileName = uniqid().'.'.$file->guessExtension();
        $path = $this->container->getParameter('kernel.root_dir').'/../web/'.$uploadDir;
        try {
            $file->move($path, $newFileName);
        } catch (FileException $e) {
            return new JsonResponse(['msg' => $e->getMessage()], 400);
        }

        $filter = 'upload_image';
        $target = $uploadDir.'/'.$newFileName;
        $cacheManager = $this->get('liip_imagine.cache.manager');
        $filterManager = $this->get('liip_imagine.filter.manager');
        $dataManager = $this->get('liip_imagine.data.manager');

        $cacheManager->store($filterManager->applyFilter($dataManager->find($filter, $target), $filter), $target, $filter);

        $newFileName = $cacheManager->resolve($target, $filter);

        return new JsonResponse(
            $response = [
                'status' => 'success',
                'src' => $newFileName,
                'width' => $width,
                'height' => $height,
            ]
        );
    }
}
