@extends('layouts.premium')

@section('content')
<main class="help-section">
        <div class="containerrr">
            <h2 class="text-center mb-4">Help & Support</h2>
            <div class="row">
                <div class="col-lg-6">
                    <h4>Frequently Asked Questions</h4>
                    <div class="accordion faq" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">How do I book an appointment?</button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">You can book an appointment through our website’s booking section.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    What services do you offer?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">We offer various medical tests, specialist consultations, and more.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    How can I cancel or reschedule my appointment?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">You can cancel or reschedule your appointment by logging into your account and selecting the appointment you want to modify.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    Do you accept insurance?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">Yes, we accept most major insurance providers. Please check with our front desk for more details.</div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6">
                    <h4>Contact Support</h4>

    <form class="contact-form" action="{{ route('help.send') }}" method="POST">
    @csrf

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
    <label for="name" class="form-label"><strong>Name</strong></label>
    <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" disabled>
</div>
    <div class="mb-3">
        <label for="email" class="form-label"><strong>Email</strong></label>
        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label"><strong>Message</strong></label>
        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>
</div>
@endsection
@if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif