<template>
  <card :title="$t('project_update')">
    <form @submit.prevent="update" @keydown="send.onKeydown($event)">
      <alert-success :form="send" :message="$t('project_update_success')" />

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品分類名稱</label>
        <div class="col-md-7">
          <select v-model="form.list.big_id" class="form-control" >
            <option v-for="option in big_id_option" :value="option.id">{{ option.name }}</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品名稱</label>
        <div class="col-md-7">
          <input v-model="form.list.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品金額</label>
        <div class="col-md-7">
          <input v-model="form.list.amount" :class="{ 'is-invalid': form.errors.has('amount') }" class="form-control" type="text" name="amount">
          <has-error :form="form" field="amount" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品圖片</label>
        <div class="col-md-7">
          <img :src="form.list.img" width="300">
          <input  type="file" class="form-control-file"  @change.prevent="handleFileUpload">
        </div>
      </div>
      <!-- Submit Button -->
      <input v-model="form.list.img"  class="form-control" type="hidden" name="image">
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="send.busy" type="success">
            {{ $t('create') }}
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
  import Form from 'vform'
  import axios from 'axios'

  export default {
    scrollToTop: false,

    metaInfo () {
      return { title: this.$t('settings') }
    },

    data: () => ({
      send: new Form({
        id : '',
        big_id : '',
        name: '',
        amount : '',
        img: '',
      }),
      form: new Form({
        list: []
      }),
      data: new Form({
        id  : ''
      }),
      big_id_option:[]
    }),
    created () {
      this.big_project_list()
      this.project_list()
    },

    methods: {
      async big_project_list () {
        var data = await this.form.get('/api/big_project/list')
        this.big_id_option = data.data.data.list
      },
      async project_list (id) {
        this.data.id = this.$route.params.id;
        var data = await this.data.post('/api/project/list')
        this.form.list = data.data.data.list[0]
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
          this.form.list.img = res.data.data.filename;
        }).catch(e => {
          console.log(e)
        })
      },
      async update () {
        console.log(this.form.list)
        this.send.big_id = this.form.list.big_id
        this.send.name = this.form.list.name
        this.send.amount = this.form.list.amount
        this.send.img = this.form.list.img
        this.send.id = this.form.list.id
        console.log(this.send)
        const { data } = await this.send.post('/api/project/update')

      }
    }
  }
</script>
