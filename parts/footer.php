<footer class="text-center fixed-bottom">
    <div class="text-center p-3" style="color: #195b8c">
        © 2023 Copyright: Dorin Sterian. All Rights Reserved
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn-style').css({
                'backgroundColor': 'white',
                'color': '#195b8c'
            }).on('click', function () {
                $('.btn-style').css({
                    'backgroundColor': 'white',
                    'color': '#195b8c',
                    'transform': 'scale(1)',
                    'border': 'none'
                });
                this.style.color = 'white';
                this.style.backgroundColor = '#1B4D3E';
                this.style.transform = 'scaleY(1.2)';
                this.style.border = '1px solid white';
            });
            $('#logout-btn').css({
                'backgroundColor': 'white',
                'color': '#195b8c'
            }).on('mouseenter', function () {
                this.style.color = 'white';
                this.style.backgroundColor = 'red';
                this.style.border = '1px solid white';
            }).on('mouseleave', function () {
                this.style.color = '#195b8c';
                this.style.backgroundColor = 'white';
                this.style.border = 'none';
            }).on('click', function () {
                location.href = 'logout.php';
            });

            function loadPage(btnId) {
                let arr = {
                    'nav-btn-1': 'parts/siteAdmin/siteAdminShowCompaniesList/siteAdminShowCompaniesList_View.php',
                    'nav-btn-2': 'parts/siteAdmin/siteAdminAddCompany/siteAdminAddCompany_View.php',
                    'nav-btn-3': 'parts/siteAdmin/siteAdminDeleteCompany/siteAdminDeleteCompany_View.php',
                    'nav-btn-4': 'parts/siteAdmin/siteAdminAddCompanyAdmin/siteAdminAddCompanyAdmin_View.php',
                    'nav-btn-5': 'parts/siteAdmin/siteAdminDeleteCompanyAdmin/siteAdminDeleteCompanyAdmin_View.php',
                    'nav-btn-6': 'parts/siteAdmin/siteAdminModifyPasswordCompanyAdmin/siteAdminModifyPasswordCompanyAdmin_View.php',
                    'nav-btn-7': 'parts/companyAdmin/companyAdminAddUser/companyAdminAddUser_View.php',
                    'nav-btn-8': 'parts/companyAdmin/companyAdminDeleteUser/companyAdminDeleteUser_View.php',
                    'nav-btn-9': 'parts/companyAdmin/companyAdminModifyPasswordUser/companyAdminModifyPasswordUser_View.php',
                    'nav-btn-10': 'parts/companyAdmin/companyAdminAddEmployee/companyAdminAddEmployee_View.php',
                    'nav-btn-11': 'parts/companyAdmin/companyAdminDeleteEmployee/companyAdminDeleteEmployee_View.php',
                    'nav-btn-12': 'parts/companyAdmin/companyAdminModifyEmployeeInfo/companyAdminModifyEmployeeInfo_View.php',
                    'nav-btn-13': 'parts/companyUser/userEmployees/userEmployees_View.php',
                    'nav-btn-14': 'parts/companyUser/userProductInventory/userProductInventory_View.php',
                    'nav-btn-15': 'parts/companyUser/userBuyProducts/userBuyProducts_View.php',
                    'nav-btn-16': 'parts/companyUser/userSellProducts/userSellProducts_View.php',
                    'nav-btn-17': 'parts/companyUser/userTransactions/userTransactions_View.php',
                    'nav-btn-18': 'parts/companyUser/userPaymentsAndRevenue/userPaymentsAndRevenue_View.php',
                    'nav-btn-19': 'parts/companyUser/userMonthlyAccountingReport/userMonthlyAccountingReport_View.php'
                };
                let navUrl;
                Object.keys(arr).forEach(key => {
                    if (key === btnId) {
                        navUrl = arr[key];
                    }
                })
                $.ajax({
                    type: 'POST',
                    url: navUrl,
                    data: navUrl,
                    success: function (result) {
                        $(".show-content").removeClass('d-flex justify-content-center align-items-center text-center').html(result);

                    }
                });
            }

            $('.btn-action').on('click', function () {
                loadPage($(this).attr('id'));
            });
        })
    </script>
</footer>
</html>