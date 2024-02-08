<div class="main_content_iner ">
    <div class="container-fluid p-3">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="single_element">
                    <div class="quick_activity">
                        <div class="row">
                            <div class="col-12">
                                <div class="quick_activity_wrap quick_activity_wrap">
                                    <div class="single_quick_activity  d-flex">
                                        <div class="count_content count_content2">
                                            <h3><span class="counter blue_color"><?= $totalHarvestQuantity ?></span> </h3>
                                            <p>Total na Naani</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity d-flex">
                                        <div class="count_content count_content2">
                                            <h3><span class="counter red_color"><?= $totalRevenueThisYear ?></span> </h3>
                                            <p>Kita Ngayong Taon</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity  d-flex">
                                        <div class="count_content count_content2">
                                            <h3><span class="counter yellow_color"><?= $totalBinhiCount ?></span> </h3>
                                            <p>Binhi</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity  d-flex">
                                        <div class="count_content count_content2">
                                            <h3><span class="counter green_color">21100</span> </h3>
                                            <p>Nagastos</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-xl-12">
                <div class="white_box mb_30 ">
                    <div class="box_header border_bottom_1px  ">
                        <div class="main-title">
                            <h3 class="mb_25">Total Income</h3>
                        </div>
                    </div>
                    <div class="income_servay">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="count_content">
                                    <h3>P <span class="counter">305</span> </h3>
                                    <p>Today's Income</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="count_content">
                                    <h3>P <span class="counter">1005</span> </h3>
                                    <p>This Week's Income</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="count_content">
                                    <h3>P <span class="counter">5505</span> </h3>
                                    <p>This Month's Income</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="count_content">
                                    <h3>P <span class="counter">155615</span> </h3>
                                    <p>This Year's Income</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bar_wev"></div>
                    <div class="col-xl-12">
                        <div class="white_box mb_30">
                            <div class="box_header ">
                                <div class="main-title">
                                    <h3 class="mb-0">Line Chart</h3>
                                </div>
                            </div>
                            <canvas style="height: 250px" id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>