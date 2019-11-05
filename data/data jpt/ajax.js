        
        chooseType = document.querySelector('select[name=choose-type]');
            chooseType.addEventListener('change',function() {
                var req = new XMLHttpRequest();
                req.onreadystatechange = function() {
                if ( req.readyState == 4 && req.status == 200 ) {
                    var theContent = document.querySelector('select[name=display-content]');


                    if ( req.response != '' ) {

                        theContent.options.length = 0;
                        var jsem = JSON.parse(req.response);
                        if ( jsem[0].name_group !== undefined ) {

                            for (var i = 0, ii = jsem.length; i < ii; i++) {
                                    theContent.add(new Option(jsem[i].name_group, jsem[i].group_id));
                            }
                        } else  if ( jsem[0].name_ad !== undefined ) {
                            for (var i = 0, ii = jsem.length; i < ii; i++) {
                                    theContent.add(new Option(jsem[i].name_ad, jsem[i].ad_id));
                            }
                        }

                    }

                }
            }

            req.open("POST", "http://localhost/horsepower/stmt-json-data/datamembersjson.php");
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            req.send(this.value);

            }, false);

            chooseType = document.querySelector('select[name=choose-type]');
            chooseType.addEventListener('change',function() {

            var type_members = document.querySelector('select[name=choose-type]').value;

             // Thsi is Script Display Members
            // if ( type_members === "Get_Groups" ) {

            // displayMembers = document.querySelector('select[name=display-content]');
            // displayMembers.addEventListener('change',function() {
            //     var req = new XMLHttpRequest();
            //     req.onreadystatechange = function() {
            //     if ( req.readyState == 4 && req.status == 200 ) {
            //         var theContent = document.querySelector('select[name=display-members]');


            //         if ( req.response != '' ) {

            //             theContent.options.length = 0;
            //             var jsem = JSON.parse(req.response);

            //                 for (var i = 0, ii = jsem.length; i < ii; i++) {
            //                         theContent.add(new Option(jsem[i].mem_name, jsem[i].sys_id));
            //                 }
                        

            //         }

            //     }
            // }


            // req.open("POST", "http://localhost/horsepower/stmt-json-data/datamembersjson.php");
            // req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // req.send('Get_members_Gp=' + this.value);

        

            // }, false);

        // }
         if ( type_members === "Get_Addad" ) {

            displayMembers = document.querySelector('select[name=display-content]');
            displayMembers.addEventListener('change',function() {
                var req = new XMLHttpRequest();
                req.onreadystatechange = function() {
                if ( req.readyState == 4 && req.status == 200 ) {
                    var theContent = document.querySelector('select[name=display-members]');


                    if ( req.response != '' ) {

                        theContent.options.length = 0;
                        var jsem = JSON.parse(req.response);

                            for (var i = 0, ii = jsem.length; i < ii; i++) {
                                    theContent.add(new Option(jsem[i].mem_name, jsem[i].sys_id));
                            }
                        

                    }

                }
            }


            req.open("POST", "http://localhost/horsepower/stmt-json-data/datamembersjson.php");
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            req.send('Get_members_Aded=' + this.value);

        

            }, false);

            

            }
            console.log(type_members);


            
            });

            // Thsi is Script Display Data Member

            showDataMember = document.querySelector('select[name=display-members]');
            showDataMember.addEventListener('change',function() {
                var req = new XMLHttpRequest();
                req.onreadystatechange = function() {
                if ( req.readyState == 4 && req.status == 200 ) {
                    // var theContent = document.querySelector('select[name=display-members]');


                    if ( req.response != '' ) {

                        // theContent.options.length = 0;
                        var jsem = JSON.parse(req.response);

                            // for (var i = 0, ii = jsem.length; i < ii; i++) {
                            //         theContent.add(new Option(jsem[i].mem_name, jsem[i].sys_id));

                            // }

                                        document.getElementById("relast").value = jsem[0].renow;
                                        document.getElementById("nam_cou").value = jsem[0].nam_cou;
                                        
                                        document.getElementById("sub_scrip").value = jsem[0].price_sh;




                    }

                }
            }
            
            req.open("POST", "http://localhost/horsepower/stmt-json-data/datamembersjson.php");
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            req.send('display_Data_member=' + this.value);

            }, false);



            // Thsi is Script Display Data Lastat

            showDataMember = document.querySelector('select[name=display-members]');
            showDataMember.addEventListener('change',function() {
                var req = new XMLHttpRequest();
                req.onreadystatechange = function() {
                if ( req.readyState == 4 && req.status == 200 ) {
                    // var theContent = document.querySelector('select[name=display-members]');

                    if ( req.response != '' ) {

                        document.getElementById("latests").value = req.responseText;

                    }

                }
            }
            
            req.open("POST", "http://localhost/horsepower/stmt-json-data/datamembersjson.php");
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            req.send('Member_Lastes=' + this.value);

            }, false);


            // Thsi is Script Submit Data Bill

            showDataMember = document.querySelector('input[name=submit-bill]');
            showDataMember.addEventListener('click',function() {
                var req = new XMLHttpRequest();
                req.onreadystatechange = function() {
                if ( req.readyState == 4 && req.status == 200 ) {
                    // var theContent = document.querySelector('select[name=display-members]');

                    if ( req.response != '' ) {

                        alert("تم قطع فاتورة بفضل الله");
                    }

                }
            }
            
            var relast = document.querySelector('input[name=relast]').value,
            renow = document.querySelector('input[name=renow]').value,
            sysID = document.querySelector('select[name=display-members]').value;

            console.log(sysID);

            req.open("POST", "http://localhost/horsepower/mrmshar.php?do=InsertBill&sysid=" + sysID);
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            req.send('relast=' + relast + '&renow=' + renow );

            }, false);