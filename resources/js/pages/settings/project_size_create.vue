<template>
  <card :title="$t('project_size_create')">
    <form @submit.prevent="create" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('project_size_success')" />

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
        <label class="col-md-3 col-form-label text-md-right">editor</label>
        <div class="col-md-7">
          <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" />
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
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

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
      admin: '',
      name: ''
    }),
    editor: ClassicEditor,
    editorData: "",
    editorConfig: {
      language: 'zh-cn',
      toolbar: {
        items: [
          'heading',
          '|',
          'bold',
          'italic',
          'link',
          'bulletedList',
          'numberedList',
          'fontColor',
          'fontSize',
          'highlight',
          'horizontalLine',
          '|',
          'alignment',
          'indent',
          'outdent',
          'codeBlock',
          '|',
          'imageUpload',
          'blockQuote',
          'insertTable',
          'mediaEmbed',
          'undo',
          'redo',
          '|',
          'removeFormat'
        ]
      },
    }
  }),

  methods: {
    async create () {
      this.form.admin = this.user['id'];
      const { data } = await this.form.post('/api/size/insert')

    }
  }
}
</script>
