<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Employees List</h3>
            <div class="card-tools">
              <button type="submit" class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus blue"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Company</th>
                  <th>Email</th>
                  <th>Phone</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees.data" :key="employee.id">
                  <td>{{ employee.firstname }}</td>
                  <!--   Below v-if are used to shorten the text of description -->
                  <td>{{ employee.lastname }}</td>

                  <td v-if="employee.company.name !== null">
                    {{ employee.company.name }}
                  </td>
                  <td v-else>{{ "Not available" }}</td>
                  <td>{{ employee.email }}</td>
                  <td>{{ employee.phone }}</td>

                  <td>
                    <a href="#">
                      <i
                        class="fa fa-edit blue"
                        @click="editModal(employee)"
                      ></i>
                    </a>
                    <a href="#" @click="deleteEmployee(employee.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination
              :data="employees"
              @pagination-change-page="getResults"
            ></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Modal Add User -->
    <div
      class="modal fade"
      id="addCourse"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addCourseModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editMode" id="addCourseModalLabel">
              Add Employee
            </h5>
            <h5 class="modal-title" v-show="editMode" id="exampleModalLabel">
              Update Employee
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- form start -->
            <form
              @submit.prevent="editMode ? updateEmployee() : CreateEmployee()"
            >
              <div class="form-group">
                <label for="Name" class="col-form-label">First Name</label>
                <div class="">
                  <input
                    v-model="form.firstname"
                    type="text"
                    name="firstname"
                    class="form-control"
                    id="firstname"
                    placeholder="FirstName"
                    :class="{ 'is-invalid': form.errors.has('firstname') }"
                  />
                  <HasError :form="form" field="firstname" />
                  <!--  //last added this -->
                  <div v-if="errors && errors.firstname" class="text-danger">
                    {{ errors.firstname[0] }}
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="Name" class="col-form-label">First Name</label>
                <div class="">
                  <input
                    v-model="form.lastname"
                    type="text"
                    name="lastname"
                    class="form-control"
                    id="lastname"
                    placeholder="Last Name"
                    :class="{ 'is-invalid': form.errors.has('lastname') }"
                  />
                  <HasError :form="form" field="lastname" />
                  <!--  //last added this -->
                  <div v-if="errors && errors.lastname" class="text-danger">
                    {{ errors.lastname[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="Company" class="col-form-label"
                  >Select Company</label
                >
                <select
                  v-model="form.company"
                  name="company"
                  id="company"
                  class="form-control"
                  required
                >
                  <option
                    v-for="company in companies.data"
                    :value="company.id"
                    :key="company.id"
                    :selected="company.name"
                  >
                    {{ company.name }}
                  </option>
                </select>
              </div>

              <div class="form-group">
                <label for="Description" class="col-form-label">Email</label>
                <div class="">
                  <input
                    v-model="form.email"
                    type="email"
                    name="email"
                    class="form-control"
                    id="email"
                    placeholder="Email"
                  />
                  <HasError :form="form" field="email" />
                  <div v-if="errors && errors.email" class="text-danger">
                    {{ errors.email[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="Description" class="col-form-label">Phone</label>
                <div class="">
                  <input
                    v-model="form.phone"
                    type="text"
                    name="phone"
                    class="form-control"
                    id="phone"
                    placeholder="Phone"
                  />
                  <HasError :form="form" field="phone" />
                  <div v-if="errors && errors.phone" class="text-danger">
                    {{ errors.phone[0] }}
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Close
                </button>
                <button
                  v-show="!editMode"
                  type="submit"
                  class="btn btn-primary"
                >
                  Save changes
                </button>
                <button v-show="editMode" type="submit" class="btn btn-primary">
                  Update changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";
export default {
  data() {
    return {
      errors: {},
      employees: {},
      results: {},
      companies: [],

      editMode: false,
      form: new Form({
        id: "",
        firstname: "",
        lastname: "",
        company: "",
        email: "",
        phone: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      axios.get("api/employees?page=" + page).then((response) => {
        this.employees = response.data;
      });
    },
    updateEmployee() {
      this.errors = {};
      let formData = new FormData();
      formData.append("firstname", this.form.firstname);
      formData.append("lastname", this.form.lastname);
      if (!this.form.company) {
        formData.append("company", "");
      } else {
        formData.append("company", this.form.company);
      }
      if (!this.form.email) {
        formData.append("email", "");
      } else {
        formData.append("email", this.form.email);
      }
      if (!this.form.phone) {
        formData.append("phone", "");
      } else {
        formData.append("phone", this.form.phone);
      }

      formData.append("_method", "put");
      // console.log(formData.append('file',this.file));

      //   console.log(this.form.email);
      //  console.log(this.form.website);

      this.$Progress.start();
      
      axios
        .post("api/employees/" + this.form.id, formData)

        .then(() => {
          $("#addCourse").modal("hide");
          this.form.errors.clear();

          Swal.fire("updated!", "employee Updated Successfully.", "success");

          this.$Progress.finish();
          //last added this
          this.form.errors.clear();
          this.getEmployeesList();
        })
      
        //last added this
        .catch((error) => {
          this.loaded = true;
      
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });

    },

    editModal(employee) {
      this.editMode = true;
      this.form.reset();
      $("#addCourse").modal("show");
      this.form.fill(employee);
    },

    deleteEmployee(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form
            .delete("api/employees/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Employee has been deleted.", "success");
              this.getEmployeesList();
            })
            .catch(() => {
              Swal.fire("Failed", "something went wrong!");
            });
        }
      });
    },

    newModal() {
      (this.editMode = false), this.form.reset();
      $("#addCourse").modal("show");
    },
    //this function is only for grabbing the file/image
    onFileChange(event) {
      const logo = event.target.files[0];
      // Set the file object onto the form...
      this.form.logo = logo;
    },
    CreateEmployee() {
      this.form
        .post("employees")
        .then((Response) => {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "employee Added Successfully",
            showConfirmButton: false,
            timer: 1500,
          });
          this.$Progress.start();
          $("#addCourse").modal("hide");
          this.form.reset();
          this.$Progress.finish();
          this.getEmployeesList();
        })
        .catch((Response) => {
          this.$Progress.fail();
        });
    },

    getEmployeesList() {
      axios
        .get("api/employees")
        //  .then(response => this.employees = response.data);
        .then(({ data }) => (this.employees = data));

      // console.log(response.data);
    },
    getCompaniesList() {
      axios
        .get("api/companies")
        //  .then(response => this.companies = response.data);
        .then(({ data }) => (this.companies = data));
      //console.log(response);
    },
  },
  mounted() {
    this.getEmployeesList();
    this.getCompaniesList();
    // console.log('I am here in the ready');
  },
};
</script>
