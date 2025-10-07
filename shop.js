//shop.js//

//==header==//
$(function () {
  //メニュースライド
  $("#menu-icon").on("click", function () {
    $("#menu-modal").fadeIn();
  });

  //メニュークローズ
  $("#close-icon").on("click", function () {
    $("#menu-modal").fadeOut();
  });

  //メニュークローズ(背景)
  $("#menu-modal").on("click", function () {
    $("#menu-modal").fadeOut();
  });
});

//==other_contents==//
$(function () {
  //other_contents return_btn
  $("#other-return-btn").on("click", function () {
    window.location.href = "../../shop.php";
  });
});

//==shop.php==//
$(function () {
  //新商品フェードイン
  $(document).ready(function () {
    $("#new-title-outer").addClass("contents-title-fadein");
    $(".white-line-n").addClass("white-line-fadein");
    $(".back-line-n").addClass("back-line-fadein");
    $(".new-img-box-1").addClass("img1-fadein");
    $(".new-img-box-2").addClass("img2-fadein");
    $(".new-img-box-3").addClass("img3-fadein");
    $(".new-txt-box-1").addClass("pt-box-1");
    $(".new-txt-box-2").addClass("pt-box-2");
    $(".new-txt-box-3").addClass("pt-box-3");
  });

  //SALEフェードイン
  function sale_fadeIn() {
    var from_position = $("#sale-title-outer").offset().top - 10;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();

    if (scroll >= from_position - windowHeight) {
      $("#sale-title-outer").addClass("contents-title-fadein");
      $(".white-line-s").addClass("white-line-fadein");
      $(".back-line-s").addClass("back-line-fadein");
      $(".sale-img-box-1").addClass("img1-fadein");
      $(".sale-img-box-2").addClass("img2-fadein");
      $(".sale-img-box-3").addClass("img3-fadein");
      $(".sale-txt-box-1").addClass("pt-box-1");
      $(".sale-txt-box-2").addClass("pt-box-2");
      $(".sale-txt-box-3").addClass("pt-box-3");
    }
  }
  //ページスクロールで呼び出し
  $(window).on("load scroll", function () {
    sale_fadeIn();
  });

  $(function () {
    //ログアウト
    $("#logout-btn").on("click", function () {
      $("#logout-modal").fadeIn();
    });
    $("#logout-return").on("click", function () {
      $("#logout-modal").fadeOut();
    });
    $("#logout-submit").on("click", function () {
      $("#logout-modal").fadeOut();
      $("#logout-thank-modal").fadeIn();
      $("#logout-thank-modal-other").fadeIn();
      $("#center-line").addClass("line-spread");
      $("#item-top").addClass("item-top-fadein");
      $("#item-bottom").addClass("item-bottom-fadein");
    });
    $("#logout-thank-modal").on("click", function () {
      window.location.href = "shop.php";
    });
    $("#logout-thank-modal-other").on("click", function () {
      window.location.href = "../../shop.php";
    });
  });
});

//==login.php==//
$(function () {
  $(function () {
    //ログインバリデーション
    $("#login-form").validate({
      rules: {
        login_id: {
          required: true,
        },
        login_pass: {
          required: true,
        },
      },

      messages: {
        login_id: {
          required: "入力してください",
        },
        login_pass: {
          required: "入力してください",
        },
      },

      //エラーの表示場所
      errorPlacement: function (error, element) {
        var name = element.attr("name");
        error.appendTo($(".err-" + name));
        $("#login-err").text("未入力があります");
      },
      errorClass: "err",
      errorElement: "p",
    });
  });
});

$(function () {
  //入力フォーム(ID)
  $("#login-id")
    .blur(function () {
      if ($(this).val().length === 0) {
        $("#login-label-id").removeClass("focus");
      } else {
        return;
      }
    })
    .focus(function () {
      $("#login-label-id").addClass("focus");
    });
});

$(function () {
  //入力フォーム(PASS)
  $("#login-pass")
    .blur(function () {
      if ($(this).val().length === 0) {
        $("#login-label-pass").removeClass("focus");
      } else {
        return;
      }
    })
    .focus(function () {
      $("#login-label-pass").addClass("focus");
    });
});

$(function () {
  //ログインエラー出力
  $(document).ready(function () {
    if ($("#err-form").val() !== "") {
      $("#login-label-id").css({
        top: "-50%",
        left: "0.5%",
        "font-size": "0.55rem",
        color: "rgb(1, 187, 255)",
      });
      $("#login-label-pass").css({
        top: "-50%",
        left: "0.5%",
        "font-size": "0.55rem",
        color: "rgb(1, 187, 255)",
      });
    }
  });
});

$(function () {
  //入力フォーム(ID)ナビ
  $("#login-id").change(function () {
    if ($(this).val() === "") {
      $("#login-label-id").text("ユーザーID(メールアドレス)");
    } else {
    }
  });
  //入力フォーム(PASS)ナビ
  $("#login-pass").change(function () {
    if ($(this).val() === "") {
      $("#login-label-pass").text("パスワード");
    } else {
    }
  });
});

$(function () {
  //パスワード表示切替
  $("#login-checkbox").on("click", function () {
    if ($(this).prop("checked")) {
      $("#login-pass").attr("type", "text");
    } else {
      $("#login-pass").attr("type", "password");
    }
  });
});

$(function () {
  //新規登録fadein
  $("#to-signup-nav").on("click", function () {
    $("#signup-ol").fadeIn();
  });
});

$(function () {
  //新規登録fadeout
  $("#signup-return-btn").on("click", function () {
    $("#signup-ol").fadeOut();
  });
});

$(function () {
  //新規登録バリデーション
  $("#signup-form").validate({
    rules: {
      first_name: {
        required: true,
      },
      last_name: {
        required: true,
      },
      post_code: {
        required: true,
      },
      prefectures: {
        required: true,
      },
      address_1: {
        required: true,
      },
      address_2: {
        required: true,
      },
      mail_ad: {
        email: true,
        required: true,
      },
      password: {
        required: true,
      },
    },

    messages: {
      first_name: {
        required: "入力してください",
      },
      last_name: {
        required: "入力してください",
      },
      post_code: {
        required: "入力してください",
      },
      prefectures: {
        required: "選択してください",
      },
      address_1: {
        required: "入力してください",
      },
      address_2: {
        required: "入力してください",
      },
      mail_ad: {
        email: "メールアドレスの形式で入力してください",
        required: "入力してください",
      },
      password: {
        required: "入力してください",
      },
    },

    //エラーの表示場所
    errorPlacement: function (error, element) {
      var name = element.attr("name");
      error.appendTo($(".err-" + name));
      $("#signup-err").text("入力エラーがあります");
    },
    errorClass: "err",
    errorElement: "p",
  });
});

$(function () {
  //戻るクリックでtopへ
  $("#login-return-btn").on("click", function () {
    window.location.href = "../../shop.php";
  });
});

//==signup_check.php==//
$(function () {
  //モーダルクリックでＴＯＰページへ
  $("#signup-result-container").on("click", function () {
    window.location.href = "login.php";
  });
});

//==all.php==//
$(function () {
  //カートバリデーション
  $(".in-cart").on("click", function () {
    var form_index = $(".in-cart").index(this);
    var amount = $(".amount").eq(form_index);
    var stock = $(".stock").eq(form_index);
    var err_amount = $(".err-amount").eq(form_index);
    //選択数量が未選択
    if (amount.val() == 0) {
      err_amount.text("数量を選択して下さい");
      return false;
    }
    //選択数量がオーバー
    else if (stock.val() - amount.val() < 0) {
      err_amount.text("在庫を上回っています");
      return false;
    } else {
    }
  });
});

$(function () {
  //数量入力アイコン
  $(".amount").each(function () {
    var target = $(this);
    //minus
    target.parent().on("click", ".spinner-minus", function () {
      if (target.val() > parseInt(target.attr("min"))) {
        target.val(function (i, oldval) {
          return --oldval;
        });
      }
    });

    //plus
    target.parent().on("click", ".spinner-plus", function () {
      if (target.val() < parseInt(target.attr("max"))) {
        target.val(function (i, oldval) {
          return ++oldval;
        });
      }
    });
  });
});

//==mycart.php==//
$(function () {
  //戻るクリックで商品一覧へ
  $("#return-all").on("click", function () {
    window.location.href = "../products/all.php";
  });

  //戻るクリックで商品一覧へ(カートが空)
  $("#mycart-return-btn").on("click", function () {
    window.location.href = "../products/all.php";
  });

  //モーダルクリックでＴＯＰページへ
  $("#cart-modal").on("click", function () {
    window.location.href = "../../shop.php";
  });
});

//==item_manage.php==//
$(function () {
  //選択イメージ表示
  $(document).on("change", ".img-name", function () {
    let elem = this;
    let fileReader = new FileReader();
    fileReader.readAsDataURL(elem.files[0]);
    fileReader.onload = function () {
      let imgTag = fileReader.result;
      $(elem).next(".edit-img").attr("src", imgTag);
      //画像をプレビュー
    };
  });
});

$(function () {
  //item_signupへ
  $('[name="to_item_signup"]').on("click", function () {
    window.location.href = "item_signup.php";
  });
});

//==order_thank.php==//
$(function () {
  //TOPへ戻る
  $("#thank-return-btn").on("click", function () {
    window.location.href = "../../shop.php";
  });
});

//==order_result.php==//
$(function () {
  //TOPへ戻る
  $("#order-result-return-btn").on("click", function () {
    window.location.href = "../../shop.php";
  });
});

//==item_signup.php==//
$(function () {
  //item_manageへ戻る
  $("#edit-wrapper").on("click", function () {
    window.location.href = "item_manage.php";
  });

  //item_manageへ戻る
  $("#signup-btn-return").on("click", function () {
    window.location.href = "item_manage.php";
  });
});

$(function () {
  //選択イメージ表示
  $(document).on("change", "#signup-img-name", function () {
    let elem = this;
    let fileReader = new FileReader();
    fileReader.readAsDataURL(elem.files[0]);
    fileReader.onload = function () {
      let imgTag = fileReader.result;
      $(elem).next(".edit-img").attr("src", imgTag);
    };
  });
});

//==item_edit.php==//
$(function () {
  //item_manageへ戻る
  $("#edit-return-btn").on("click", function () {
    window.location.href = "item_manage.php";
  });

  $("#edit-return-back-btn").on("click", function () {
    window.location.href = "item_manage.php";
  });
});
