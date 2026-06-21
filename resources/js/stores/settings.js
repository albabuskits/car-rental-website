import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'

export const useSettingsStore = defineStore('settings', () => {
  const currency = ref({ code: 'USD', symbol: '$' })
  const tax = ref({ enabled: true, amount: 45 })
  const loaded = ref(false)

  async function load() {
    if (loaded.value) return
    try {
      const res = await axios.get('/api/settings')
      currency.value = res.data.currency
      tax.value = res.data.tax
      loaded.value = true
    } catch {}
  }

  function formatPrice(amount) {
    return currency.value.symbol + Number(amount).toFixed(amount % 1 ? 2 : 0)
  }

  return { currency, tax, loaded, load, formatPrice }
})