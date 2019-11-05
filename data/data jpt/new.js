$(function(){
    $(".confirm").click(function(){
        return confirm("هل انت متكد من الحذف");
    });

    // Click Show Datelse
    $(".click-detilse").click(function(){
        $(".show-detilse").fadeToggle(500);
    });
    

        $('.star').focus(function(){
                
            $(this).attr('type','password');

            
            }).blur(function(){
                $(this).attr('type', 'text');
            
            });

            // Show Group 

            $(".group-print").click(function(){
                $(".all-cho").toggle();
                $(".choosing-toggle").toggle();
            });
            $(".focus").focus();
            $("#renow").keyup(function(){
                var decount = $("#renow").val() - $("#relast").val(),
                    countUn = $("#nam_cou").val(),
                    subScr  = $("#sub_scrip").val(),
                    latests = $("#latests").val();

                $("#descount").attr("value",decount);
                $("#total").attr("value",(countUn * decount) + + + subScr + + + latests);

                // console.log( (countUn * decount) + + + subScr + + + latests )
            });

            // Select Focus
            $(".focus-select").click(function() {
                $("select").focus();
            });

});
