$("#selectAddress").change(function() {
  let str = ""
  $("select option:selected").each(function() {
    str = $(this).text();
    key = $(this).val();
  });
  let action = $("#selectAddressForm").attr("action");
  let method = $("#selectAddressForm").attr("method");

  let line1 = $("#line1");
  let line2 = $("#line2");
  let line3 = $("#line3");
  let city = $("#city");
  let postCode = $("#postCode");

  let request = $.ajax({
    url: "http://localhost/landlordapp/register",
    type: "POST",
    data: {"address": key},
    dataType: "json",
    success: function (data) {
      console.log(data);
      let temp = $("#temp");
      console.log('---');
      console.log(data.Items[0].Line1);
      console.log(data.Items[0].Line2);
      console.log(data.Items[0].Line3);
      console.log(data.Items[0].City);
      console.log(data.Items[0].PostalCode);

      line1.val(data.Items[0].Line1);
      line2.val(data.Items[0].Line2);
      line3.val(data.Items[0].Line3);
      city.val(data.Items[0].City);
      postCode.val(data.Items[0].PostalCode);

      
      temp.html("<p>\
      ", data.Items[0].Line1, "\
      ", data.Items[0].Line2, "\
      ", data.Items[0].Line3, "\
      ", data.Items[0].CountryName, "\
      ", data.Items[0].PostalCode, "\
      </p>");
    },
    error: function () {
      console.log("Request failed, data didn't get set");
    }
  });


  request.fail(function(msg) {
    console.log(msg);
  });

});