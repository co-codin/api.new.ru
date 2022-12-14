<?php

namespace Modules\Contact\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Contact\Http\Resources\ContactResource;
use Modules\Contact\Models\Contact;
use Modules\Contact\Repositories\ContactRepository;

class ContactController extends Controller
{
    public function __construct(
        protected ContactRepository $contactRepository
    ) {}

    public function index()
    {
        $contacts = $this->contactRepository->jsonPaginate();

        return ContactResource::collection($contacts);
    }

    public function show(int $contact)
    {
        $contact = $this->contactRepository->find($contact);

        return new ContactResource($contact);
    }
}
