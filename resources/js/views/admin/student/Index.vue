<template>
    <div>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Student List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link :to="{name:'dashboard'}">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">Student</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                                <div class="card-tools">
                                    <button
                                        @click = "createStudent"
                                        class="btn btn-success btn-md"
                                    >
                                        Add Student
                                        <i class="fas fa-plus fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table
                                    id="example2"
                                    class="table table-bordered table-hover"
                                >
                                    <thead>
                                        <tr>
                                            <th>SI</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="students.length > 0">
                                        <tr v-for="(student,index) in students" :key="student.id">
                                            <td>{{index + 1}}</td>
                                            <td>{{student.name | capitalize }}</td>
                                            <td>{{student.email }}</td>
                                            <td>{{student.created_at | formatDate}}</td>
                                            <td>
                                                <button
                                                    @click="editStudent(student)"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    @click="deleteStudent(student.id)"
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- add Student modal -->
        <div
            class="modal fade"
            id="addStudentModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addStudentModal"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title" id="addStudentModal">
                            edit Student <i class="fas fa-edit fa-fw"></i>
                        </h5>
                        <h5 v-else class="modal-title" id="addStudentModal">
                            Add Student <i class="fas fa-plus fa-fw"></i>
                        </h5>

                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click="closeModal"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <form @submit.prevent="editMode ? updateStudent() : addStudent()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Name</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        class="form-control"

                                        aria-describedby="emailHelp"
                                        placeholder="Enter Name"
                                        :class="{ 'is-invalid': form.errors.has('name') }"
                                    />
                                    <HasError :form="form" field="name" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Email</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.email"
                                        class="form-control"

                                        aria-describedby="emailHelp"
                                        placeholder="Enter Email"
                                        :class="{ 'is-invalid': form.errors.has('email') }"
                                    />
                                    <HasError :form="form" field="email" />
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button
                            @click="closeModal"
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button v-if="editMode" type="submit" class="btn btn-primary" :disabled="form.busy">
                                Update
                            </button>
                             <button v-else type="submit" class="btn btn-primary" :disabled="form.busy">
                                Submit
                            </button>
                        </div>
                     </form>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
   data(){
    return{
         form : new Form({
            id:'',
            name: '',
            email: '',
        }),
        students: {},
        editMode : false
      }
   },

   mounted(){
        this.getStudent();
   },

    methods:{
        async getStudent(){
           this.$Progress.start()
           await this.form.get('/admin/student')
            .then(res => {
                this.students = res.data
                this.$Progress.finish()
            })
            .catch(e => {
                this.$Progress.fail()
            })
        },
        async addStudent(){
             this.$Progress.start()
            await this.form.post('/admin/student-store')
            .then(res => {
                if(this.form.successful){
                    $('#addStudentModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: "Student Created Successfully"
                    })

                    this.getStudent();
                    this.$Progress.finish()
                }
            })
            .catch(e => {
                 this.$Progress.fail()
            })
        },
        editStudent(student){
            this.editMode = true;
            this.form.clear();
            this.form.reset();
            this.form.fill(student);
            $('#addStudentModal').modal('show')
        },
        async updateStudent(){
             this.$Progress.start()
             await this.form.put('/admin/student-update/'+this.form.id)
             .then(res=>{
                 if(this.form.successful){
                    $('#addStudentModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: "Student Updated Successfully"
                    })
                     this.getStudent();
                    this.$Progress.finish()
                }
             })
             .catch(e=>{
                this.$Progress.fail()
             })

        },
         closeModal(){
             $('#addStudentModal').modal('hide')
               $('#showDistDivModal').modal('hide')
        },
        createStudent(){
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $('#addStudentModal').modal('show')
        },
        deleteStudent(id){
            swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.form.delete('/admin/student-delete/'+id)
                .then(res => {
                    swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                     this.getStudent();
                     toast.fire({
                        icon: 'success',
                        title: "Student Deleted Successfully"
                    })
                })
                .catch(error => {
                     swal.fire(
                    'Failed!',
                    'Something went wrong',
                    'warning'
                    )
                })

            }
            })
        }
    }
};
</script>
