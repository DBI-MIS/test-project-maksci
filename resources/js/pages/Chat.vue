<script setup lang="ts">
import axios from 'axios'
import { ref, nextTick } from 'vue'

type Message = {
  role: 'user' | 'assistant'
  content: string
}

const messages = ref<Message[]>([])
const input = ref('')
const loading = ref(false)

const sendMessage = async () => {
  if (!input.value.trim()) return

  const userMessage = input.value
  messages.value.push({ role: 'user', content: userMessage })

  input.value = ''
  loading.value = true

  await nextTick()

  try {
    const res = await axios.post('/api/chat', {
      message: userMessage,
    })

    messages.value.push({
      role: 'assistant',
      content: res.data.reply,
    })
  } catch (e) {
    messages.value.push({
      role: 'assistant',
      content: 'Error getting response',
    })
  }

  loading.value = false
}
</script>

<template>
  <div class="flex flex-col h-screen bg-gray-900 text-white">

    <!-- Messages -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
      <div
        v-for="(msg, i) in messages"
        :key="i"
        class="max-w-2xl mx-auto"
      >
        <div
          :class="msg.role === 'user'
            ? 'bg-blue-600 ml-auto text-right'
            : 'bg-gray-700 mr-auto'"
          class="p-3 rounded-lg w-fit"
        >
          {{ msg.content }}
        </div>
      </div>

      <div v-if="loading" class="text-gray-400 text-center">
        AI is typing...
      </div>
    </div>

    <!-- Input -->
    <div class="p-4 border-t border-gray-700 flex gap-2">
      <input
        v-model="input"
        @keyup.enter="sendMessage"
        class="flex-1 p-3 rounded bg-gray-800 text-white outline-none"
        placeholder="Ask something..."
      />

      <button
        @click="sendMessage"
        class="bg-blue-600 px-4 py-2 rounded"
      >
        Send
      </button>
    </div>

  </div>
</template>