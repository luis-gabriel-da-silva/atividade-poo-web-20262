<template>
  <q-page padding>
    <!-- Formulário de criação/edição de clientes -->
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
              v-model="formObject.name"
              stack-label
              required
              label="Nome"
            />

            <q-input
              v-model="formObject.email"
              stack-label
              required
              type="email"
              label="E-mail"
            />

            <q-input
              v-model="formObject.phone"
              stack-label
              required
              type="tel"
              label="Telefone"
            />

            <q-input
              v-model="formObject.birth_date"
              stack-label
              required
              type="date"
              label="Data de nascimento"
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
            v-model="search"
            :label="`Clientes (${paging?.total ?? '..'})`"
            placeholder="Pesquisar"
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
            E-mail: {{ customer.email }}
          </q-item-label>

          <q-item-label caption>
            Telefone: {{ customer.phone }}
          </q-item-label>

          <q-item-label caption>
            Nascimento: {{ customer.birth_date }}
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
import { onMounted, ref, watch } from 'vue'
import {
  createCustomer,
  deleteCustomer,
  getCustomers,
  updateCustomer,
} from './_api'
import { Dialog, Notify } from 'quasar'

// Parâmetros de listagem
const search = ref('')
const paging = ref({
  data: [],
  current_page: 1,
  last_page: 1,
  total: 0,
})

// Parâmetros de criação/edição
const saving = ref(false)
const openForm = ref(false)
const formObject = ref(null)

// Listagem de clientes
const fetchCustomers = () => {
  getCustomers({
    page: paging.value.current_page,
    search: search.value,
  }).then((data) => {
    paging.value = data
  }).catch((e) => {
    Notify.create({
      type: 'negative',
      message: 'Falha ao carregar clientes',
      caption: e?.response?.data?.message ?? 'Analisar logs',
    })
  })
}

// Atualiza a listagem quando a pesquisa muda
watch(search, () => {
  paging.value.current_page = 1
  fetchCustomers()
})

// Criação/edição de clientes
const manageCustomer = (_customer) => {
  formObject.value = {
    id: _customer?.id ?? null,
    name: _customer?.name ?? '',
    email: _customer?.email ?? '',
    phone: _customer?.phone ?? '',
    birth_date: _customer?.birth_date ?? '',
  }

  openForm.value = true
}

// Envia dados para a API
const doSubmit = () => {
  saving.value = true

  const request = formObject.value.id
    ? updateCustomer(formObject.value.id, formObject.value)
    : createCustomer(formObject.value)

  request
    .then(() => {
      Notify.create(
        formObject.value.id
          ? 'Cliente atualizado!'
          : 'Cliente criado!'
      )

      openForm.value = false
      formObject.value = null
      fetchCustomers()
    })
    .catch((e) => {
      Notify.create({
        type: 'negative',
        message: 'Falha na operação',
        caption: e?.response?.data?.message ?? 'Analisar logs',
      })
    })
    .finally(() => {
      saving.value = false
    })
}

// Exclusão de clientes
const confirmToDelete = (_customer) => {
  Dialog.create({
    message: 'Confirma exclusão do cliente?',
    caption: 'Esta ação não pode ser desfeita',
    cancel: true,
    persistent: true,
  }).onOk(() => {
    deleteCustomer(_customer.id)
      .then(() => {
        Notify.create('Cliente excluído!')
        fetchCustomers()
      })
      .catch((e) => {
        Notify.create({
          type: 'negative',
          message: 'Falha na operação',
          caption: e?.response?.data?.message ?? 'Analisar logs',
        })
      })
  })
}

// Inicializa a listagem
onMounted(() => {
  fetchCustomers()
})
</script>