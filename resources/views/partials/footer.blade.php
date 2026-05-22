 <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h1 class="text-primary mb-0">Vegmart</h1>
                                <p class="text-secondary mb-0">Fresh products</p>
                            </a>
                        </div>
                        
                        <div class="offset-lg-6 col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Why People Like us!</h4>
                            <p class="mb-4">We sell fresh Groceries directly from farmers to you which ensures purity, 
                                quality assurity and helps farmers and small sellers earn more without any commission in between.  </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Account</h4>
                            <a class="btn-link" href="{{ route('profile') }}">My Account</a>
                            <a class="btn-link" href="{{ route('view.orders') }}">Your Orders</a>
                            <a class="btn-link" href="{{ route('cart.show') }}">Shopping Cart</a>
                            <a class="btn-link" href="{{route('contact')}}">Contact Us</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address: Thaltej, Ahmedabad - 380061</p>
                            <p>Email: fruitable.contact@gmail.com</p>
                            <p>Phone: +91 8167859357</p>
                            <p>Payment Accepted</p>
                            <img src="{{ asset('theme/img/payment.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   
