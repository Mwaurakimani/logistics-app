<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="log-in-pannel">
        <div class="holder">
            <div class="bright-description">
                <div class="icon-section">
                    <img src="/storage/icons/lorry.png" alt="">
                </div>
            </div>
            <JetAuthenticationCard style="width: 50%">
                <h4 class="">Sign In</h4>
                <JetValidationErrors class="mb-4" />
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <JetLabel for="email" value="Email" />
                        <JetInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                    </div>

                    <div class="mt-4">
                        <JetLabel for="password" value="Password" />
                        <JetInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="current-password"
                        />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background-color: red">
                            Log in
                        </JetButton>
                    </div>
                </form>
            </JetAuthenticationCard>
        </div>
    </div>
</template>

<style lang="scss" >

.log-in-pannel{
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;

    .holder{
        width: 100%;
        height: 100%;
        background-color: red;
        display: flex;

        .bright-description{
            width: 50%;
            height: 100%;
            background-color: #262626;
            display: flex;
            align-items: center;
            justify-content: center;
            .icon-section{
                width: 350px;
                height: 400px;
            }
        }

        h4{
            font-size: 2em;
            padding: 20px;
        }
    }
}


</style>

