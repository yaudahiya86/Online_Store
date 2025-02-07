</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; FATIMAH BOUQUET 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin untuk logout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">Pilih Logout jika ingin mengakhiri sesi.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('css/admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('css/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('css/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('css/admin/js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('css/admin/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('css/admin/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('css/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('css/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('css/admin/js/demo/datatables-demo.js') }}"></script>
@yield('script')
</body>

</html>
