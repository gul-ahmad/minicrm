<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Companies</h3>
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Logo</th>
                  <th>Website</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="company in companies.data" :key="company.id">
                  <td>{{ company.name }}</td>
                  <td>{{ company.email }}</td>

                  <td>
                    <img
                      style="width:100px,height:100px"
                      v-bind:src="'/storage/' + company.logo"
                      width="35 px"
                      height="23px"
                      alt=""
                      title=""
                    />
                  </td>
                  <td>{{ company.website }}</td>

                  <td>
                    <a href="#">
                      <i
                        class="fa fa-edit blue"
                        @click="editModal(company)"
                      ></i>
                    </a>
                    <a href="#" @click="deleteCompany(company.id)">
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
              :data="companies"
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
              Add Company
            </h5>
            <h5 class="modal-title" v-show="editMode" id="exampleModalLabel">
              Update Company
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
            <form @submit.prevent="editMode ? updateCompany() : createSeries()">
              <div class="form-group">
                <label for="Name" class="col-form-label">Name</label>
                <div class="">
                  <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="form-control"
                    id="name"
                    placeholder="Name"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                  />
                  <HasError :form="form" field="name" />
                  <!--  //last added this -->
                  <div v-if="errors && errors.name" class="text-danger">
                    {{ errors.name[0] }}
                  </div>
                </div>
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
                <label for="logo" class="col-form-label">Logo</label>
                <div class="">
                  <input
                    type="file"
                    v-on:change="onFileChange"
                    name="logo"
                    class="form-control"
                    id="logo"
                    placeholder="Logo"
                  />

                  <HasError :form="form" field="logo" />
                  <div v-if="errors && errors.logo" class="text-danger">
                    {{ errors.logo[0] }}
                  </div>
                  <div v-if="form.progress">
                    Progress: {{ form.progress.percentage }}%
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="Description" class="col-form-label">Website</label>
                <div class="">
                  <input
                    v-model="form.website"
                    type="text"
                    name="website"
                    class="form-control"
                    id="website"
                    placeholder="Website"
                  />
                  <HasError :form="form" field="website" />
                  <div v-if="errors && errors.website" class="text-danger">
                    {{ errors.website[0] }}
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
      companies: {},
      //used EditMode here beacuse I am using one popup modal for both create and update forms
      //So edit mode is used
      editMode: false,
      form: new Form({
        id: "",
        name: "",
        email: "",
        logo: null,
        website: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      axios.get("api/companies?page=" + page).then((response) => {
        this.companies = response.data;
      });
    },
    updateCompany() {
      this.errors = {};
      //after appending the form values i am sending them as argument in axios.post
      let formData = new FormData();
      formData.append("name", this.form.name);
      if (!this.form.email) {
        formData.append("email", "");
      } else {
        formData.append("email", this.form.email);
      }
      if (!this.form.website) {
        formData.append("website", "");
      } else {
        formData.append("website", this.form.website);
      }

      formData.append("logo", this.form.logo);

      formData.append("_method", "put");
      // console.log(formData.append('file',this.file));

      //   console.log(this.form.email);
      //  console.log(this.form.website);
      this.$Progress.start();

      //to tell about the put method i have declared the put in the append above like we do in laravel

      axios
        .post("api/companies/" + this.form.id, formData)

        .then(() => {
          $("#addCourse").modal("hide");
          this.form.errors.clear();

          Swal.fire("updated!", "Company Updated Successfully.", "success");

          this.$Progress.finish();
          //last added this
          this.form.errors.clear();
          this.getCompaniesList();
        })

        .catch((error) => {
          this.loaded = true;

          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });
    },

    editModal(company) {
      this.editMode = true;
      this.form.reset();
      $("#addCourse").modal("show");
      this.form.fill(company);
    },

    deleteCompany(id) {
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
            .delete("api/companies/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.getCompaniesList();
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
    createSeries() {
      this.form
        .post("companies")
        .then((Response) => {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Company Added Successfully",
            showConfirmButton: false,
            timer: 1500,
          });
          this.$Progress.start();
          $("#addCourse").modal("hide");
          this.form.reset();
          this.$Progress.finish();
          this.getCompaniesList();
        })
        .catch((Response) => {
          this.$Progress.fail();
        });
      //  console.log('I am coming here in the createUser');
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
    this.getCompaniesList();
    // console.log('I am here in the ready');
  },
};
</script>
