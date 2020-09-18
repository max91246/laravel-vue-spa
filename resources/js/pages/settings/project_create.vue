<template>
  <card :title="$t('project_create')">
    <form @submit.prevent="create" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('project_success')" />

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品分類名稱</label>
        <div class="col-md-7">
            <select v-model="form.big_id" class="form-control" >
              <option v-for="option in big_id_option" :value="option.id">{{ option.name }}</option>
            </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品名稱</label>
        <div class="col-md-7">
          <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品圖片</label>
        <div class="col-md-7">
          <img :src="form.img">
          <input  type="file" class="form-control-file"  @change.prevent="handleFileUpload">
        </div>
      </div>
      <!-- Submit Button -->
      <input v-model="form.image"  class="form-control" type="hidden" name="image">
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">
            {{ $t('create') }}
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
  import Form from 'vform'
  import { mapGetters } from 'vuex'
  import axios from 'axios'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  data: () => ({
    data: new Form(),
    form: new Form({
      big_id : '',
      name: '',
      img: '',
    }),
    big_id_option:[]
  }),
  created () {
    this.get_big_pro()
  },
  methods: {
    async get_big_pro () {
      var data = await this.data.get('/api/big_project/list')
      this.big_id_option = data.data.data.list;
      this.form.big_id = this.big_id_option[0].id
    },
    async create () {
      console.log(this.form)
      const { data } = await this.form.post('/api/project/insert')
    },
    handleFileUpload(event){

      let image = event.target.files[0];

      let formData = new FormData();
      formData.append('image', image); //required

      axios({
        method: 'POST',
        url: '/api/image/upload',
        data: formData
      }).then(res => {
        this.form.img = res.data.data.filename;
      }).catch(e => {
        console.log(e)
      })


    }
  }
}
</script>
