
        </div>
        </div>
        </div>
        </div>

        </main>


    <?php wp_footer(); ?>
    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
       
        $(document).ready(function () {
            var table = $('#allusers').DataTable();
            $('.catering_menu').on( 'click', 'a', function () {                                   
                $(".catering_menu a").removeClass("_active");
                $(this).addClass("_active"); 
               
            table
                .columns(2)
                .search(  $(this).attr('data') )
                .draw();
            });
        })
        $(document).ready(function () {           
            var table = $('#payments').DataTable();
            $('.catering_menu').on( 'click', 'a', function () {
                $(".catering_menu a").removeClass("_active");
                $(this).addClass("_active");  
               
            table
                .columns( 3 )
                .search(  $(this).attr('data') )
                .draw();
            });
        })
        $(document).ready(function () {
            $('#cancle').DataTable();
        })

       


    </script>

    </html>