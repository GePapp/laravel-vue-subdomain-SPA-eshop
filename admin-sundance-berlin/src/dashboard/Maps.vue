<template>
<div class="container">
    <div class="col-md-12 mt-5">
        <div class="card">
            <!-- card-header -->
            <div class="card-header">
                <p class="text-center">Maps</p>
                <div class="text-right">
                    <!-- Modal Button -->
                    <!-- To open different modals use  @click="newModal" instead of modal's id data-target="#addNew"  -->
                    <button class="btn btn-outline-dark btn-sm" @click="createModal">Add New Map</button>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- card-body -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>title</th>
                            <th>description</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="map in maps" :key="map.id">
                            <td>{{ map.id }}</td>
                            <td>{{ map.title }}</td>
                            <td class="text-left" v-html="map.description">{{ map.description }}</td>
                            <td class="align-middle">
                                <img class="index-map-img" :src="'/img/maps/' + map.imageName">                             
                            </td>
                            <td>{{ map.price }}</td>
                            <td>
                                <img src="/img/icons/edit.png" class="conf-icons" @click="editModal(map.id)" />
                                <img src="/img/icons/delete.png" class="conf-icons" @click="deleteMap(map.id)" />
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!-- card-footer -->
            <div class="card-footer">
                <div class="align-items-center justify-content-center pag-footer">

                    <!--Pagination-->
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
                            <a class="page-link" @click.prevent="changePage(1)">First page</a>
                        </li>

                        <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
                            <a class="page-link" @click.prevent="changePage(pagination.current_page - 1)">Previous</a>
                        </li>
            
                        <!-- *A -->
                        <li class="page-item" v-show="$parent.smalDev" v-for="page in pages"  :key="page" :class="isCurrentPage(page) ? 'active' : ''">
                            <a class="page-link" @click.prevent="changePage(page)">{{ page }}
                                <span v-if="isCurrentPage(page)" class="sr-only">(current)</span>
                            </a>
                        </li>
                        <!-- *A End --> 

                        <li class="page-item" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                            <a class="page-link" @click.prevent="changePage(pagination.current_page + 1)">Next</a>
                        </li>
                        
                        <li class="page-item" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                            <a class="page-link" @click.prevent="changePage(pagination.last_page)">Last page</a>
                        </li>

                    </ul>
                    <!--Pagination End-->
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>

<!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p v-show="!editmode">Add New Map</p>
                    <p v-show="editmode">Update Map's Data</p>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Form -->
                <form>
                    <div class="modal-body">

                        <div class="form-group">
                            <input v-model="ecMap.title" name="title" id="title" placeholder="Title" class="form-control">
                            <div v-show="errors.title" class="warn text-left">{{ this.errors.title }}</div>
                        </div>

                        <div class="form-group">
                            <vue-editor v-model="ecMap.description" :editor-toolbar="customToolbar" name="description" id="description" placeholder="Description ..."  />
                            <div v-if="errors.description" class="warn text-left">{{ this.errors.description }}</div>
                        </div>

                        <div class="form-group text-left">
                            <label for="imageName" class="control-label">Select Image</label>                                
                            <input type="file" @change="encodeImageFileAsURL" class="form-input" name="imageName" id="imageName">
                            <button type="button" @click="resetImage" class="btn btn-outline-dark btn-sm" id="btn-file-reset">Reset Image</button>
                            <img v-if="showImgUrl" class="map-img" v-bind:src="showImgUrl" /> 
                            <div v-if="errors.imageName" class="warn text-left">{{ this.errors.imageName }}</div>                            
                            </div>

                        <div class="form-group">
                            <input v-model="ecMap.price" name="price" id="price" placeholder="Preis. Example: 15.20" class="form-control">
                            <div v-if="errors.price" class="warn text-left">{{ this.errors.price }}</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button v-show="!editmode" type="submit" @click.prevent="createMap" class="btn btn-outline-dark btn-sm">Add</button>
                        <button v-show="editmode" type="submit" @click.prevent="updateMap" class="btn btn-outline-dark btn-sm">Update</button>
                    </div>
                </form>
                <!-- /End Form -->

            </div>
        </div>
    </div>
    <!-- End Modal -->

</div>
</template>

<script>
// Import VueEditor
import { VueEditor } from "vue2-editor";
import axios from 'axios'
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000'

export default {
        // *A is for pagination links, 1, 2, 3, ..... between
    data() {
        return {
            // VueEditor Toolbar Configuration (Custom Toolbar)
            customToolbar: [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction
                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']     
            ],
            // Current Maps
            maps: {},
            // Edit or Create Map
            ecMap: {
                title: '',
                description: '',
                imageName: '',
                price: ''
            },
            pagination: 
            {
                current_page: 1,
                last_page: '', 
                total: ''
            },
            // *A
            offset: 2,
            // Mode for change between Edit & Create Modal Window
            editmode: false,
            // Edit & Create Modal Form Validation Errors
            errors: {
                title: '',
                description: '',
                imageName: '',
                price: ''
            },
            // Variable to show uploaded image
            showImgUrl: ''       
        }
    },
    // ------------  METHODS -------------------------
    methods: {
        loadMaps() {
            axios.get('/api/map?page=' + this.pagination.current_page).then(({
                data
            }) => (this.maps = data.data, this.pagination.current_page = data.current_page, this.pagination.last_page = data.last_page, this.pagination.total = data.total))
        },
        encodeImageFileAsURL(e) {
            // e.target Get the element that triggered the event:
            let file = e.target.files[0];
            // console.log(file['size']);
            let reader = new FileReader();
            if(file){
            // Image size must be < 2Mb
                if (file['size'] < 2111775) {
                    // set showImgUrl to show uploaded image
                    this.showImgUrl = URL.createObjectURL(file);
                    reader.onloadend = (file) => {
                        // push file into form.imageName
                        let dataURL = reader.result;
                        // empty first form.imageName if old form.imageName existing
                        this.ecMap.imageName = '';
                        // set fresh form.imageName
                        this.ecMap.imageName = reader.result;
                    }
                    reader.readAsDataURL(file);
                }
            } else {
                swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You are uploading a large file',
                })
            }
        },
        resetImage() {
            let imgName = $("#imageName")       
                imgName.wrap('<form>').closest('form').get(0).reset()
                imgName.unwrap()
                // empty form.imageName
                this.ecMap.imageName = ''
                // empty showImgUrl to show uploaded image
                this.showImgUrl = ''  
        },
        // Show edit modal
        editModal(id) {
            this.editmode = true;
            this.ecMap = {}
            this.errors = {}
            this.resetImage()
            axios.get('/api/map/show/' + id)
                .then(response => {this.ecMap = response.data, this.showImgUrl = "/img/maps/" + response.data.imageName})
            $('#addNew').modal('show');
        },
        // Show create modal
        createModal() {
            this.editmode = false;
            this.ecMap = {}
            this.errors = {}
            this.resetImage()
            $('#addNew').modal('show');
        },
        // Execute Create Map
        createMap() {
            this.errors = {}
            // Validation
            if(!this.ecMap.title) {
                this.errors.title = '** Title is required'
            }
            if(!this.ecMap.description) {
                this.errors.description = '** Description is required'
            }
            if(!this.ecMap.imageName) {
                this.errors.imageName = '** Select a image'
            }
            if(!this.ecMap.price) {
                this.errors.price = '** Price is required'
            }
            // Execute
            if(jQuery.isEmptyObject(this.errors)) {
            axios.post('/api/map/store', this.ecMap)
                .then(() => {
                    $('#addNew').modal('hide')
                    this.loadMaps()
                    // if success, emit Fire event to reload page, close modal and show sweetalert2 success popup
                    swal.fire({
                        type: 'success',
                        text: 'User created Successfully'
                    })
                })
                .catch(() => {})
            }
        },
        // Execute update map
        updateMap() {
            this.errors = {}
            // Validation
            if(!this.ecMap.title) {
                this.errors.title = '** Title is required'
            }
            if(!this.ecMap.description) {
                this.errors.description = '** Description is required'
            }
            if(!this.ecMap.imageName) {
                this.errors.imageName = '** Select a image'
            }
            if(!this.ecMap.price) {
                this.errors.price = '** Price is required'
            }
            // Execute
            if(jQuery.isEmptyObject(this.errors)) {
                axios.put('/api/map/update/' + this.ecMap.id, this.ecMap)
                    .then(() => {
                        $('#addNew').modal('hide')
                        this.loadMaps()
                        swal.fire(
                            'Updated!',
                            'Map data  has been updated.',
                            'success'
                        )
                    })
                    .catch(() => {
                        swal.fire("Failed", "There was something wrong", "warning")
                    })
            }
        },
        deleteMap(id) 
        {
            if(confirm("delete map")){
                axios.delete('/api/map/destroy/' + id)
                .then(() => {                       
                    this.loadMaps()                      
                    })
            }           
        },
        // Pagination
        // *A
        changePage(page) {
            if (page > this.pagination.last_page) {
                page = this.pagination.last_page;
            }
            this.pagination.current_page = page;
            this.loadMaps()            
            },
            // *A
            isCurrentPage(page){
                return this.pagination.current_page === page
            },
    },
    computed: {
        // *A
        pages() {
            let pages = []
            let from = 1
            if (from < 1) {
                from = 1
            }
            let to = Math.ceil(this.pagination.total / this.offset)
            while (from <= to) {
                pages.push(from)
                from++
            }
            return pages
        }

    },
    created() {
        // load Maps
        this.loadMaps()
    }      
}
</script>
<style lang="scss" scoped>
    .map-img 
    {
        width: 8%;
        height: 8%;
        margin-left: 20px;    
    }
    .index-map-img 
    {
        max-width: 100px;
        max-height: 173px;
    }
   
    .conf-icons {
        cursor: pointer;
        padding-right: 8px;
    }
    .pag-footer 
    {
        padding-top: 20px;
            li
            {
                cursor: pointer;
            }  
    }
</style>