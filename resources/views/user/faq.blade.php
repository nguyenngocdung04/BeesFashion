@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Faq</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Faq</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container faq-section">
                <div class="row gy-4">
                    <div class="col-xl-10 mx-auto">
                        <div class="faq-title-2 sticky">
                            <h3>How Can We Help You?</h3>
                            <div>
                                <div class="faq-search"><input type="search" name="text"
                                        placeholder="Search here...."><i class="iconsax"
                                        data-icon="search-normal-2"></i></div><button
                                    class="btn btn_black">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-10 mx-auto">
                        <div class="custom-accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"><span>1.
                                                Pellentesque habitant morbi tristique
                                                senectus et netus?</span></button></h2>
                                    <div class="accordion-collapse collapse show" id="collapseOne">
                                        <div class="accordion-body">
                                            <p>"Brewing tea is akin to picking low-hanging fruit - it's easily
                                                identifiable
                                                and immensely satisfying. Just as one can derive pleasure from the
                                                simplicity of tea-making, in photography, I've found that sharing my
                                                work is
                                                paramount to improvement. Each sip of perfectly brewed tea or shared
                                                photograph carries its own story, evoking emotions and connections
                                                beyond
                                                mere words."</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"><span>2. What are
                                                the
                                                shipping costs and estimated delivery time?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseTwo"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Just as the art of brewing tea is a blend of science and artistry, so too
                                                is
                                                photography a fusion of technique and creativity. Each click of the
                                                shutter
                                                captures a moment in time, preserving emotions, stories, and
                                                perspectives.
                                                It's in the sharing of these moments that the true magic unfolds,
                                                weaving a
                                                tapestry of experiences that transcends boundaries and speaks to the
                                                soul.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"><span>3. How can I
                                                downgrade to an earlier version of Dummy Content?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseThree"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Once the earlier version is activated, test your website thoroughly to
                                                ensure
                                                that everything is working as expected. Check that the dummy content is
                                                being generated correctly and that there are no compatibility issues
                                                with
                                                other plugins or themes.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"><span>4. How can I
                                                upgrade from Shopify 2.5 to shopify 3?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseFour"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>As of my last update, there wasn't a direct upgrade path from Shopify 2.5
                                                to
                                                Shopify 3, as there's no versioning system like software updates.
                                                However,
                                                Shopify continually updates its platform with new features and
                                                improvements.
                                                To take advantage of these updates, you generally don't need to perform
                                                any
                                                manual upgrades.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"><span>5. Under what
                                                license are Regular Labs extensions released?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseFive"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Regular Labs extensions are typically released under the GNU General
                                                Public
                                                License (GPL) version 2 or later.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"><span>6. What is the
                                                Regular Labs Library?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseSix"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>The Regular Labs Library is a collection of Joomla extensions developed
                                                by
                                                Regular Labs (formerly known as NoNumber). Regular Labs is a well-known
                                                developer in the Joomla community, creating a variety of extensions to
                                                enhance and extend the functionality of Joomla websites. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSeven"><span>7. Can I
                                                turn
                                                on/off some blocks on the page?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseSeven"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Yes, you can typically turn on/off blocks on a webpage depending on the
                                                level
                                                of control and access you have. If you're a user interacting with a
                                                webpage,
                                                you might not have the ability to directly toggle blocks on or off
                                                unless
                                                the webpage provides such functionality through options or settings.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEight"><span>8. Do you
                                                guys
                                                offer a refund or exchange?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseEight"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>As an AI developed by OpenAI, I don't directly offer refunds or exchanges
                                                as
                                                I'm not a product or service. However, many companies do have policies
                                                in
                                                place for refunds or exchanges depending on their terms and conditions.
                                                It's
                                                best to check with the specific company you're dealing with regarding
                                                their
                                                refund or exchange policies.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseNine"><span>9. What I
                                                have to
                                                do when I need your support?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseNine"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>When you need support, simply ask! Whether you need help with a problem,
                                                advice on a decision, information on a topic, or just someone to talk
                                                to,
                                                I'm here to assist you to the best of my ability. Just provide me with
                                                the
                                                details of what you need, and I'll do my best to help.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTen"><span>10. Would
                                                assistance be available to upload the template if
                                                needed?</span></button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="collapseTen"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Yes, assistance would be available to upload the template if needed.
                                                Whether
                                                you're looking to upload a document, a file, or any other template, feel
                                                free to ask for guidance, and I'll do my best to assist you through the
                                                process.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End container content -->
@endsection
