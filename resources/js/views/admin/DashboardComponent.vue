 <template>
    <div>
         <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{students}}</h3>

                <p>Total Student</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
             <a to="javascript:void(0)" class="small-box-footer">view</a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{users}}</h3>

                <p>Total User</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <router-link to="/admin/division" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>


          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    </div>
 </template>

  <script>
    export default {
        data(){
            return{
                users: '',
                students: '',
            }
        },
        mounted(){
            this.dashboardInfo();
        },
        methods:{
            async dashboardInfo(){
                 this.$Progress.start()
                 await axios.get('/admin/dashboard')
                    .then(res => {
                        this.users = res.data.users
                        this.students = res.data.students

                        this.$Progress.finish()
                    })
                    .catch(e => {
                        this.$Progress.fail()
                    })
            }
        }
    }
  </script>

    <style scoped>

    </style>
