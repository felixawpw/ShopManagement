@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="col-md-8 col-12 mr-auto ml-auto">
    <!--      Wizard container        -->
    <div class="wizard-container">
      <div class="card card-wizard" data-color="rose" id="wizard">
        <form action="{!! route('report_generate_penjualan') !!}" method="GET" target="blank_" id="formCetakLaporan">
          <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
          <div class="card-header text-center">
            <h3 class="card-title">
              Format Tampilan Laporan Penjualan
            </h3>
            <h5 class="card-description"></h5>
          </div>
          <div class="wizard-navigation">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link active" href="#periode_laporan" data-toggle="tab" role="tab">
                  Periode Laporan
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#format" data-toggle="tab" role="tab">
                  Tipe Laporan
                </a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="periode_laporan">
                <h5 class="info-text"> Pilih periode penampilan laporan penjualan!</h5>
                <div class="row justify-content-center">
                  <div class="col-md-10 mt-3">
                    <div class="row">
                      <div class="form-group col-md-5">
                        <input type="text" class="form-control datepicker" id="tanggal_awal" name="awal" required placeholder="Tanggal Awal">
                      </div>
                      <div class="form-group col-md-2 text-center">
                        <label>Hingga</label>
                      </div>
                      <div class="form-group col-md-5">
                        <input type="text" class="form-control datepicker" id="tanggal_akhir" name="akhir" required placeholder="Tanggal Akhir">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="format">
                <h5 class="info-text"> Pilih Tipe Laporan (salah satu) </h5>
                <div class="row justify-content-center">
                  <div class="col-lg-10">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="choice" data-toggle="wizard-radio">
                          <input type="radio" name="tipe" value="grafik">
                          <div class="icon">
                            <i class="material-icons">show_chart</i>
                          </div>
                          <h6>Grafik</h6>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="choice" data-toggle="wizard-radio">
                          <input type="radio" name="tipe" value="printout">
                          <div class="icon">
                            <i class="material-icons">print</i>
                          </div>
                          <h6>Print Out</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="mr-auto">
              <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
            </div>
            <div class="ml-auto">
              <input type="button" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
              <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="Finish" style="display: none;">
            </div>
            <div class="clearfix"></div>
          </div>
        </form>
      </div>
    </div>
    <!-- wizard container -->
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
    $('#nav_report').addClass('active');
    $('#nav_report_1').addClass('active');
	});
</script>

<script>
  var tanggalAwal, tanggalAkhir;

	$(document).ready(function(){
    initWizard();
    setTimeout(function() {
      $('.card.card-wizard').addClass('active');
    }, 600);

    md.initFormExtendedDatetimepickers();
    if ($('.slider').length != 0) {
      md.initSliders();
    }
  });

  //Wizard Initialization
  function initWizard() {
    var $validator = $('.card-wizard form').validate({
      rules: {
        awal: {
          required: true,
        },
        akhir: {
          required: true,
        },
      },

      highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
      },
      success: function(element) {
        $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
      },
      errorPlacement: function(error, element) {
        $(element).append(error);
      }
    });

    // Wizard Initialization
    $('.card-wizard').bootstrapWizard({
      'tabClass': 'nav nav-pills',
      'nextSelector': '.btn-next',
      'previousSelector': '.btn-previous',

      onNext: function(tab, navigation, index) {
        var $valid = $('.card-wizard form').valid();
        if (!$valid) {
          $validator.focusInvalid();
          return false;
        }
        // switch (index) {
        //   case 1:
        //     tanggalAwal = new Date($('#tanggal_awal').val());
        //     tanggalAkhir = new Date($('#tanggal_akhir').val());
        //     break;
        //   case 2:

        //     break;
        // }
      },

      onInit: function(tab, navigation, index) {
        //check number of tabs and fill the entire row
        var $total = navigation.find('li').length;
        var $wizard = navigation.closest('.card-wizard');

        $first_li = navigation.find('li:first-child a').html();
        $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
        $('.card-wizard .wizard-navigation').append($moving_div);

        refreshAnimation($wizard, index);

        $('.moving-tab').css('transition', 'transform 0s');
      },

      onTabClick: function(tab, navigation, index) {
        var $valid = $('.card-wizard form').valid();

        if (!$valid) {
          return false;
        } else {
          return true;
        }
      },

      onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index + 1;

        var $wizard = navigation.closest('.card-wizard');

        // If it's the last tab then hide the last button and show the finish instead
        if ($current >= $total) {
          $($wizard).find('.btn-next').hide();
          $($wizard).find('.btn-finish').show();
        } else {
          $($wizard).find('.btn-next').show();
          $($wizard).find('.btn-finish').hide();
        }

        button_text = navigation.find('li:nth-child(' + $current + ') a').html();

        setTimeout(function() {
          $('.moving-tab').text(button_text);
        }, 150);

        var checkbox = $('.footer-checkbox');

        if (!index == 0) {
          $(checkbox).css({
            'opacity': '0',
            'visibility': 'hidden',
            'position': 'absolute'
          });
        } else {
          $(checkbox).css({
            'opacity': '1',
            'visibility': 'visible'
          });
        }

        refreshAnimation($wizard, index);
      }
    });


    // Prepare the preview for profile picture
    $("#wizard-picture").change(function() {
      readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function() {
      wizard = $(this).closest('.card-wizard');
      wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
      $(this).addClass('active');
      $(wizard).find('[type="radio"]').removeAttr('checked');
      $(this).find('[type="radio"]').attr('checked', 'true');
    });

    $('[data-toggle="wizard-checkbox"]').click(function() {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).find('[type="checkbox"]').removeAttr('checked');
      } else {
        $(this).addClass('active');
        $(this).find('[type="checkbox"]').attr('checked', 'true');
      }
    });

    $('.set-full-height').css('height', 'auto');

    //Function to show image before upload

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $(window).resize(function() {
      $('.card-wizard').each(function() {
        $wizard = $(this);

        index = $wizard.bootstrapWizard('currentIndex');
        refreshAnimation($wizard, index);

        $('.moving-tab').css({
          'transition': 'transform 0s'
        });
      });
    });

    function refreshAnimation($wizard, index) {
      $total = $wizard.find('.nav li').length;
      $li_width = 100 / $total;

      total_steps = $wizard.find('.nav li').length;
      move_distance = $wizard.width() / total_steps;
      index_temp = index;
      vertical_level = 0;

      mobile_device = $(document).width() < 600 && $total > 3;

      if (mobile_device) {
        move_distance = $wizard.width() / 2;
        index_temp = index % 2;
        $li_width = 50;
      }

      $wizard.find('.nav li').css('width', $li_width + '%');

      step_width = move_distance;
      move_distance = move_distance * index_temp;

      $current = index + 1;

      if ($current == 1 || (mobile_device == true && (index % 2 == 0))) {
        move_distance -= 8;
      } else if ($current == total_steps || (mobile_device == true && (index % 2 == 1))) {
        move_distance += 8;
      }

      if (mobile_device) {
        vertical_level = parseInt(index / 2);
        vertical_level = vertical_level * 38;
      }

      $wizard.find('.moving-tab').css('width', step_width);
      $('.moving-tab').css({
        'transform': 'translate3d(' + move_distance + 'px, ' + vertical_level + 'px, 0)',
        'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

      });
    }
  }
</script>
@endsection