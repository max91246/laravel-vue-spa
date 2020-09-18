<template>
  <card :title="$t('project_info_create')">
    <form @submit.prevent="create" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('project_info_success')" />

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品分類名稱</label>
        <div class="col-md-7">
            <select v-model="big_id" class="form-control" >
              <option v-for="option in big_id_option" :value="option.id">{{ option.name }}</option>
            </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品對應內容</label>
        <div class="col-md-7">
          <select v-model="product_id" class="form-control" >
            <option v-for="option in show_project" :value="option.id" >{{ option.name }}</option>
          </select>
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

    }),
    big_id : '',
    product_id:'',
    big_id_option:[],
    product:[],
    show_project : []
  }),
  watch:{
    big_id(newval,oldval){
      this.get_pro(newval);
    },
    product(newval,oldval){
      console.log(newval)
      console.log(oldval)
    }
  },
  computed: {
    product_date: function () {
      return this.product[this.big_id]
    }
  },
  created () {
    this.get_big_pro()
  },
  methods: {
    async get_big_pro () {

      await axios({
        method: 'GET',
        url: '/api/big_project/list',
        data: ''
      }).then(res => {
        this.big_id_option = res.data.data.list;
        this.big_id = this.big_id_option[0].id

      }).catch(e => {
        console.log(e)
      })
    },
    get_pro () {
      if (this.product[this.big_id] == undefined){
        axios({
          method: 'POST',
          url: '/api/project/list',
          data: {'big_id' : this.big_id}
        }).then(res => {
          this.product[this.big_id] = res.data.data.list;
          this.show_project = this.product[this.big_id]
          this.product_id = this.show_project[0].id
        }).catch(e => {
          console.log(e)
        })
      }else{
        this.show_project = this.product[this.big_id]
        this.product_id = this.show_project[0].id
      }


    },
    async create () {
      //const { data } = await this.form.post('/api/project_info/insert')
    }
  }
}
</script>
