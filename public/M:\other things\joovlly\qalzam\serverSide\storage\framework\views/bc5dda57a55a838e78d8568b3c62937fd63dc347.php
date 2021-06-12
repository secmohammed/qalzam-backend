<?php $__env->startSection('content'); ?>
    <section class="slider">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 item flex">
                    <div class="inner-text">
                        <h1 class="title"><?php echo e(__('website.index.welcome.title-1')); ?> <br/><?php echo e(__('website.index.welcome.title-2')); ?></h1>
                        <p class="text"><?php echo e(__('website.index.welcome.desc-1')); ?><br/><br/> <?php echo e(__('website.index.welcome.desc-2')); ?></p>
                        <a class="bottom" href="<?php echo e(route('website.branches')); ?>">
                            <?php echo e(__('website.index.welcome.food-menu')); ?>

                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path d="M2.89638 6.3293L8.44673 11.8643C8.62858 12.0455 8.923 12.0452 9.10455 11.8634C9.28595 11.6815 9.28548 11.3869 9.10361 11.2055L3.88363 5.99998L9.1038 0.794442C9.28565 0.613036 9.28612 0.318639 9.10474 0.136765C9.01373 0.0455932 8.8945 7.59915e-06 8.77528 7.58873e-06C8.65635 7.57833e-06 8.5376 0.045288 8.44675 0.135827L2.89638 5.67069C2.80879 5.75783 2.75964 5.87642 2.75964 5.99998C2.75964 6.12354 2.80893 6.242 2.89638 6.3293Z" fill="white"></path>
                                </g>
                            </svg></a>
                    </div>
                </div>
                <div class="col-sm-7 item text-center">
                    <div class="inner">
                        <div class="carousel slide carousel-fade" id="carouselExampleIndicators" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li class="active" data-target="#carouselExampleIndicators" data-slide-to="0"><img src="<?php echo e(asset('assets/website/images/slider/img-1.jpg')); ?>" alt=""></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"><img src="<?php echo e(asset('assets/website/images/slider/img-2.jpg')); ?>" alt=""></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"><img src="<?php echo e(asset('assets/website/images/slider/img-3.jpg')); ?>" alt=""></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"><img src="<?php echo e(asset('assets/website/images/slider/img-4.jpg')); ?>" alt=""></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="4"><img src="<?php echo e(asset('assets/website/images/slider/img-5.jpg')); ?>" alt=""></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active"><img src="<?php echo e(asset('assets/website/images/slider/img-1.jpg')); ?>" alt=""></div>
                                <div class="carousel-item">       <img src="<?php echo e(asset('assets/website/images/slider/img-2.jpg')); ?>" alt=""></div>
                                <div class="carousel-item">       <img src="<?php echo e(asset('assets/website/images/slider/img-3.jpg')); ?>" alt="">     </div>
                                <div class="carousel-item">       <img src="<?php echo e(asset('assets/website/images/slider/img-4.jpg')); ?>" alt=""></div>
                                <div class="carousel-item">       <img src="<?php echo e(asset('assets/website/images/slider/img-5.jpg')); ?>" alt="">   </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--End slider-->
    <!-- Begin best-seller -->

    <section class="best-seller">
        <div class="container">
            <div class="head-title">
                <h2 class="title"><?php echo e(__('website.index.best-seller')); ?></h2>
            </div>
                <div class="seller-slider">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('most-sell-product', [])->html();
} elseif ($_instance->childHasBeenRendered('kf0EUd4')) {
    $componentId = $_instance->getRenderedChildComponentId('kf0EUd4');
    $componentTag = $_instance->getRenderedChildComponentTagName('kf0EUd4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kf0EUd4');
} else {
    $response = \Livewire\Livewire::mount('most-sell-product', []);
    $html = $response->html();
    $_instance->logRenderedChild('kf0EUd4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
        </div>
    </section>
    <!--End  best-seller-->
        <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-sm-7 item"><img src="<?php echo e(asset('assets/website/images/about.png')); ?>" alt=""></div>
                <div class="col-sm-5 item flex">
                    <div class="inner">
                        <h2 class="title"><?php echo e(__('website.index.experience.title')); ?></h2>
                        <p><?php echo e(__('website.index.experience.desc-2')); ?></p>
                        <a class="bottom" href="<?php echo e(route('website.about')); ?>">
                            <?php echo e(__('website.index.experience.more')); ?>

                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path d="M2.89638 6.3293L8.44673 11.8643C8.62858 12.0455 8.923 12.0452 9.10455 11.8634C9.28595 11.6815 9.28548 11.3869 9.10361 11.2055L3.88363 5.99998L9.1038 0.794442C9.28565 0.613036 9.28612 0.318639 9.10474 0.136765C9.01373 0.0455932 8.8945 7.59915e-06 8.77528 7.58873e-06C8.65635 7.57833e-06 8.5376 0.045288 8.44675 0.135827L2.89638 5.67069C2.80879 5.75783 2.75964 5.87642 2.75964 5.99998C2.75964 6.12354 2.80893 6.242 2.89638 6.3293Z" fill="#D1362A"></path>
                                </g>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--End minabout-->
    <!--Begin most-wanted -->
    <section class="most-wanted">
        <div class="container">
            <div class="head-title">
                <h2 class="title"><?php echo e(__('website.index.most-wanted')); ?></h2><a class="more" href="<?php echo e(route('website.branches')); ?>">
                    <?php echo e(__('website.index.food-menu')); ?>

                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0)">
                            <path d="M3.86175 8.43907L11.2622 15.8191C11.5047 16.0607 11.8973 16.0603 12.1393 15.8178C12.3812 15.5753 12.3806 15.1826 12.1381 14.9407L5.17809 7.99998L12.1383 1.05926C12.3808 0.817384 12.3814 0.424854 12.1396 0.182355C12.0182 0.0607929 11.8593 1.14038e-05 11.7003 1.13899e-05C11.5417 1.1376e-05 11.3834 0.0603866 11.2623 0.181105L3.86175 7.56092C3.74497 7.6771 3.67944 7.83523 3.67944 7.99998C3.67944 8.16472 3.74516 8.32266 3.86175 8.43907Z" fill="#E31D1A"></path>
                        </g>
                    </svg></a>
            </div>
            <div class="row">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('most-ordered-product', ['action' => 'start-shopping','pagination' => 'false'])->html();
} elseif ($_instance->childHasBeenRendered('vX7V5HR')) {
    $componentId = $_instance->getRenderedChildComponentId('vX7V5HR');
    $componentTag = $_instance->getRenderedChildComponentTagName('vX7V5HR');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('vX7V5HR');
} else {
    $response = \Livewire\Livewire::mount('most-ordered-product', ['action' => 'start-shopping','pagination' => 'false']);
    $html = $response->html();
    $_instance->logRenderedChild('vX7V5HR', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        </div>
    </section>



































































    <!--End most-wanted -->
    <!--End food-menu-->
    <section class="partners">
        <div class="container">
            <div class="head-title">
                <h2 class="title"><?php echo e(__('website.index.reviews.title')); ?></h2>
            </div>
            <div class="partners-slider">
                <?php for($i = 0 ; $i < 5 ; $i++): ?>
                <div class="item">
                    <p><?php echo e(__('website.index.reviews.desc-1')); ?><br/><?php echo e(__('website.index.reviews.desc-2')); ?></p>
                    <h4 class="name">عبدالقاسم المسعود</h4>
                    <div class="photo"><img src="<?php echo e(asset('/assets/website/images/par.svg')); ?>" alt="" title=""></div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section><!--End  minpartners-->
    <section class="min-video">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 item">
                    <h2 class="title"><?php echo e(__('website.index.resort.title-1')); ?><br/><?php echo e(__('website.index.resort.title-2')); ?></h2>
                    <p><?php echo e(__('website.index.resort.desc-1')); ?></p>
                </div><a class="bla-2 cd-single-point" href="https://www.youtube.com/watch?v=QAaDq0X4X-U"> <i class="cd-img-replace"> </i><i class="innerbc">
                        <svg width="23" height="29" viewBox="0 0 23 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.835352 0.998526C0.479041 1.20118 0.258911 1.57953 0.258911 1.98921V26.9983C0.258911 27.6277 0.769257 28.1379 1.3985 28.1379C2.02774 28.1379 2.53809 27.6277 2.53809 26.9983V3.99394L19.4103 14.0381L7.00319 22.0317C6.47423 22.3727 6.32152 23.0779 6.66245 23.6069C7.00356 24.136 7.70859 24.2887 8.23774 23.9476L22.191 14.9576C22.5227 14.7439 22.7202 14.3739 22.7132 13.9794C22.7061 13.5849 22.4957 13.2221 22.1567 13.0203L1.9814 1.00992C1.62889 0.800427 1.19166 0.795869 0.835352 0.998526Z" fill="#D1362A"></path>
                        </svg></i></a>
            </div>
        </div>
    </section><!--End minvideo-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.website', ['activeRoute' => 'home'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/badawy/Joovlly/qalzam/app/Domain/Website/Resources/Views/pages/home.blade.php ENDPATH**/ ?>