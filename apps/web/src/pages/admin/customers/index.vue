<template>
  <q-page padding>

    <!-- Form (Dialog) de criação/edição de clientes -->
    <q-dialog v-model="openForm">
      <q-card style="width: 700px; max-width: 80vw">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">
            {{ formObject?.id ? 'Editar cliente' : 'Novo cliente' }}
          </div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <q-form
            v-if="formObject"
            class="q-gutter-y-md"
            @submit="doSubmit"
          >
            <q-input
              stack-label
              required
              label="Nome"
              v-model="formObject.name"
            />
            <q-input
              stack-label
              required
              type="email"
              label="E-mail"
              v-model="formObject.email"
            />
            <q-input
              stack-label
              label="Telefone"
              mask="(##) #####-####"
              unmasked-value
              v-model="formObject.phone"
            />
            <q-input
              stack-label
              required
              type="date"
              label="Data de nascimento"
              v-model="formObject.birth_date"
            />
            <div class="full-width bg-grey-1 q-py-md">
              <q-btn-group spread flat>
                <q-btn
                  flat
                  no-caps
                  v-close-popup
                  label="Cancelar"
                  icon="cancel"
                  color="primary"
                />
                <q-btn
                  flat
                  no-caps
                  :loading="saving"
                  type="submit"
                  label="Salvar"
                  icon="save"
                  color="positive"
                />
              </q-btn-group>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <!-- Lista de clientes -->
    <q-list separator>
      <q-item class="row">
        <q-item-section avatar>
          <q-avatar icon="people" />
        </q-item-section>
        <q-item-section>
          <q-input
            stack-label
            debounce="400"
            v-model="search"
            :label="`Clientes (${paging?.total ?? '..'})`"
            placeholder="Pesquisar"
            @update:model-value="onSearch"
          />
        </q-item-section>
        <q-item-section side>
          <q-btn
            round
            flat
            color="secondary"
            icon="add"
            @click="manageCustomer()"
          />
        </q-item-section>
      </q-item>
      <q-item
        v-for="customer in paging.data"
        :key="customer.id"
      >
        <q-item-section>
          <q-item-label>
            {{ customer.name }}
          </q-item-label>
          <q-item-label caption>
            {{ [customer.email, customer.phone].filter(Boolean).join(' - ') }}
          </q-item-label>
        </q-item-section>
        <q-item-section side>
          <q-btn-group rounded flat>
            <q-btn
              flat
              color="primary"
              icon="edit"
              @click="manageCustomer(customer)"
            />
            <q-btn
              flat
              color="negative"
              icon="delete"
              @click="confirmToDelete(customer)"
            />
          </q-btn-group>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section class="flex flex-center">
          <q-pagination
            v-model="paging.current_page"
            :max="paging.last_page"
            @update:model-value="fetchCustomers"
          />
        </q-item-section>
      </q-item>
    </q-list>
  </q-page>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { createCustomer, deleteCustomer, getCustomers, updateCustomer } from './_api';
import { Dialog, Notify } from 'quasar';

// Parâmetros de listagem
const search = ref('')
const paging = ref({
  current_page: 1,
  last_page: 1,
})

// Parâmetros de criação/edição
const saving = ref(false)
const openForm = ref(false)
const formObject = ref(null)

// Lista (paginada/index) clientes
const fetchCustomers = () => {
  getCustomers({
    page: paging.value.current_page,
    search: search.value || undefined,
  }).then((data) => {
    paging.value = data
  })
}

// Ao pesquisar, volta para a primeira página
const onSearch = () => {
  paging.value.current_page = 1
  fetchCustomers()
}

// Prevent side-effect
// Copia o objeto da lista para o objeto de edição
const manageCustomer = (_customer) => {
  formObject.value = {
    id: _customer?.id ?? null,
    name: _customer?.name ?? null,
    email: _customer?.email ?? null,
    phone: _customer?.phone ?? null,
    birth_date: _customer?.birth_date ?? null,
  }
  openForm.value = true
}

// Envia dados para API, para criar ou atualizar o registro
const doSubmit = () => {
  saving.value = true
  if (formObject?.value?.id) {
    updateCustomer(formObject.value.id, formObject.value).then(() => {
      Notify.create('Cliente atualizado!')
      fetchCustomers()
      formObject.value = null
      openForm.value = false
    }).finally(() => {
      saving.value = false
    }).catch((e) => {
      console.log(e?.response)
      Notify.create({
        type: 'negative',
        message: 'Falha na operação',
        caption: e?.response?.data?.message ?? 'Analisar logs',
      })
    })
  } else {
    createCustomer(formObject.value).then(() => {
      Notify.create('Cliente criado!')
      fetchCustomers()
      formObject.value = null
      openForm.value = false
    }).finally(() => {
      saving.value = false
    }).catch((e) => {
      console.log(e?.response)
      Notify.create({
        type: 'negative',
        message: 'Falha na operação',
        caption: e?.response?.data?.message ?? 'Analisar logs',
      })
    })
  }
}

// Confirma e executa exclusão do registro
const confirmToDelete = (_customer) => {
  Dialog.create({
    message: 'Confirma exclusão do cliente?',
    caption: 'Esta ação não pode ser desfeita',
  }).onOk(() => {
    deleteCustomer(_customer.id).then(() => {
      Notify.create('Cliente excluído!')
      fetchCustomers()
    }).catch((e) => {
      console.log(e?.response)
      Notify.create({
        type: 'negative',
        message: 'Falha na operação',
        caption: e?.response?.data?.message ?? 'Analisar logs',
      })
    })
  })
}

// Ao inicializar, executa listagem
onMounted(() => {
  fetchCustomers()
})
</script>