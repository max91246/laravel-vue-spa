<template>
  <card :title="$t('big_project_create')">
    <form @submit.prevent="create" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('big_project_success')" />

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品分類名稱</label>
        <div class="col-md-7">
          <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name" />
        </div>
      </div>


      <!-- Submit Button -->
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
export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  data: () => ({
    form: new Form({
      id: '',
      name: ''
    })
  }),

  methods: {
    async create () {
      this.form.id = this.user['id'];
      const { data } = await this.form.post('/api/big_project/insert')

    }
  }
}
</script>
