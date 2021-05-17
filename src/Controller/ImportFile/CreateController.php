<?php

namespace App\Controller\ImportFile;

use App\Message\SplitProductsFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateController extends AbstractController
{

    public function _get(): Response
    {
        return new Response(
            '<html><body style="text-align:center;padding-top:6rem;"><form enctype="multipart/form-data" method="POST">
<label>Select a file to import products:</label><br /><br />
<input type="file" name="file"><br /><br />
<button type="submit">Send</button>
</form></body></html>'
        );
    }

    public function _post(Request $request, MessageBusInterface $bus): Response
    {
        /** @var UploadedFile */
        $file = $request->files->get('file');

        if (empty($file)) {
            return new Response("No file specified", Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $filename = uniqid('products_', true) . '.' . $file->getClientOriginalExtension();
        $upload_dir = __DIR__ . '/../../../data/';

        try {
            $file->move($upload_dir, $filename);
        } catch (FileException $e) {
            throw new FileException('Failed to upload file.');
        }

        $path = $upload_dir . $filename;

        $bus->dispatch(new SplitProductsFile($path));

        return new Response(
            '<html><body style="text-align:center;padding-top:6rem;"><h3>Your file has been sent.</h3></body></html>'
        );
    }
}
