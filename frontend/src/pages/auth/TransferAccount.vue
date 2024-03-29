<template>

    <PageWrapper class="q-mt-lg">
        <CardWrapper
            title="Transfer Account"
            iconHeader="switch_account"
            note="*After verify your account, you will be able to login with your new credentials."
            goBack
        >
            <FormWrapper
                buttonText="Transfer Account"
                buttonIcon="supervisor_account"
                @submit="makeValidationRequest(password, password_confirm)"
            > 
                <!-- From Email -->  
                <p>Transfer from:</p>
                <q-input
                    v-model="email"
                    type="email"
                    filled
                    readonly
                >
                    <template #prepend>
                        <q-icon name="email" />
                    </template>
                </q-input>

                <!-- Token -->
                <q-input
                    v-model="key"
                    class="q-mt-none"
                    filled
                    disable
                    readonly
                >
                    <template #prepend>
                        <q-icon name="key" />
                    </template>
                </q-input>

                <!-- To Email -->
                <p>To:</p>
                <q-input
                    v-model="transfer"
                    type="email"
                    filled
                    readonly
                >
                    <template #prepend>
                        <q-icon name="email" />
                    </template>
                </q-input>

                <!-- Set New Password -->
                <p>Choose your password:</p>
                <div>
                    <q-input
                        label="Enter password"
                        v-model="password"
                        type="password"
                        filled
                    >
                        <!-- Icon -->
                        <template v-slot:prepend>
                            <q-icon name="lock" />
                        </template>
                        
                        <!-- Validation -->
                        <template v-slot:append>
                            <q-icon name="info">
                                <q-tooltip>
                                    <PasswordCheck
                                        :password="password"
                                        :password_confirm="password_confirm"
                                    />
                                </q-tooltip>
                            </q-icon>
                        </template>
                    </q-input>
                    <q-input
                        v-model="password_confirm"
                        label="Confirm password"
                        type="password"
                        filled
                    >
                        <template v-slot:prepend>
                            <q-icon name="lock" />
                        </template>
                    </q-input>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-center q-mt-sm">
                    <q-checkbox 
                        v-model="agreed" 
                        label="I agree with" 
                        class="q-mr-xs"
                    />
                    <div @click="showTerms = true"><u>terms &amp; conditions</u></div>
                </div>
                <q-dialog v-model="showTerms">
                    <TermsConditions class="q-mt-xl" />
                </q-dialog>
            </FormWrapper>
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import { updateEmail } from 'src/apis/auth.js';
import { passwordRequirements} from 'src/modules/globals.js';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';
import PasswordCheck from 'components/PasswordCheck.vue';
import TermsConditions from 'src/pages/guest/compliance/TermsConditions.vue';

export default {
    name: 'TransferAccount',
    components: {
        PageWrapper, CardWrapper, FormWrapper, PasswordCheck, TermsConditions
    },

    emits: [
        'authorize'
    ],

    setup() {
        return {
            loading: ref(false),
            showTerms: ref(false)
        };
    },
    
    data() {
        return {
            email: this.$route.params.email,
            key: this.$route.params.key,
            transfer: this.$route.params.transfer,
            password: '',
            password_confirm: '',
            agreed: false
        };
    },
    
    methods: {
        async makeValidationRequest(pw, pw_confirm) {
            try {
                // Validate
                const passwordCheck = passwordRequirements(pw, pw_confirm);
                if(passwordCheck) throw passwordCheck;
                if(!this.agreed) throw 'Please agree to our terms & conditions.'
                // Transfer
                // Fullpath includes Token to verify its user
                this.$toast.load();
                const response = await updateEmail(this.$route.fullPath, pw, pw_confirm, this.agreed);
                this.$toast.success(response.data.message);
                this.password = '';
                this.password_confirm = '';
                this.agreed = false;
                // Login
                this.$user.setToken(response.data.token);
                this.$emit('authorize');
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            }
        }
    }
};
</script>
