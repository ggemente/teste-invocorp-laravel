<script setup>
import { Link, Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { AlertCircle, CheckCircle2 } from 'lucide-vue-next';

defineProps({
    title: String,
});

const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);
const flashError = computed(() => page.props.flash.error);
const errors = computed(() => page.props.errors);
const hasErrors = computed(() => Object.keys(errors.value).length > 0);

</script>

<template>
    <Head :title="title ? `${title} - Gestão de Livros e Autores` : 'Gestão de Livros e Autores'" />

    <div class="min-h-screen bg-background text-foreground font-sans antialiased">
        <div class="container mx-auto mt-8 mb-12 px-4">
            <header class="mb-8">
                <Link :href="route('books.index')">
                    <h1 class="text-4xl font-bold text-center text-primary hover:text-primary/90 transition-colors duration-300">
                        Gestão de Livros e Autores
                    </h1>
                </Link>
                <nav class="mt-6 p-4 bg-card shadow-md rounded-lg flex justify-center space-x-6">
                    <Link
                        :href="route('books.index')"
                        class="text-lg font-semibold text-card-foreground hover:text-primary transition-colors duration-300 pb-1 border-b-2"
                        :class="{ 'border-primary': $page.url.startsWith('/books'), 'border-transparent hover:border-primary/50': !$page.url.startsWith('/books') }"
                    >
                        Livros
                    </Link>
                    <Link
                        :href="route('authors.index')"
                        class="text-lg font-semibold text-card-foreground hover:text-primary transition-colors duration-300 pb-1 border-b-2"
                        :class="{ 'border-primary': $page.url.startsWith('/authors'), 'border-transparent hover:border-primary/50': !$page.url.startsWith('/authors') }"
                    >
                        Autores
                    </Link>
                </nav>
            </header>

            <div class="my-6 space-y-4">
                <Alert v-if="flashSuccess" variant="success">
                    <CheckCircle2 class="h-4 w-4" />
                    <AlertTitle>Sucesso!</AlertTitle>
                    <AlertDescription>
                        {{ flashSuccess }}
                    </AlertDescription>
                </Alert>
                <Alert v-if="flashError" variant="destructive">
                    <AlertCircle class="h-4 w-4" />
                    <AlertTitle>Erro!</AlertTitle>
                    <AlertDescription>
                        {{ flashError }}
                    </AlertDescription>
                </Alert>
                <Alert v-if="hasErrors" variant="destructive">
                    <AlertCircle class="h-4 w-4" />
                    <AlertTitle>Oops! Algo deu errado.</AlertTitle>
                    <AlertDescription>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
                        </ul>
                    </AlertDescription>
                </Alert>
            </div>

            <main class="bg-card p-6 sm:p-8 shadow-xl rounded-lg">
                <slot />
            </main>

            <footer class="text-center text-muted-foreground mt-12 text-sm">
                <p>&copy; {{ new Date().getFullYear() }} Gestão de Livros e Autores. Todos os direitos reservados.</p>
            </footer>
        </div>
    </div>
</template>