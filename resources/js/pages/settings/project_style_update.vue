<template>
  <card :title="$t('project_style_update')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('project_style_update_success')" />

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品尺寸名稱</label>
        <div class="col-md-7">
          <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name" />
        </div>
      </div>


      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品色系代號</label>
        <div class="col-md-7">
          <input v-model="form.color" :class="{ 'is-invalid': form.errors.has('color') }" class="form-control" type="text" name="color">
          <has-error :form="form" field="name" />
        </div>
      </div>


      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">
            {{ $t('update') }}
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
    form: new Form({
      id: '',
      name: '',
      color: ''
    }),
    data: new Form({
      id  : ''
    })
  }),
  created () {
    this.project_style_one()
  },

  methods: {
    async project_style_one () {
      this.data.id = this.$route.params.id;
      var data = await this.data.post('/api/style/list')
      this.form.id = data.data.data.list.id
      this.form.name = data.data.data.list.name
      this.form.color = data.data.data.list.color
    },
    async update () {
      const { data } = await this.form.post('/api/style/update')

    }
  }
}
</script>
