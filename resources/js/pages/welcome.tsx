import { Form, Head } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/participants';

export default function Welcome() {
    return (
        <>
            <Head title="Register" />
            <div className="flex min-h-svh flex-col items-center justify-center bg-background p-6 md:p-10">
                <Card className="w-full max-w-sm">
                    <CardHeader>
                        <CardTitle>Register</CardTitle>
                        <CardDescription>
                            Enter your details to get your personal link. It
                            stays valid for seven days.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form
                            {...store.form()}
                            disableWhileProcessing
                            className="flex flex-col gap-6"
                        >
                            {({ processing, errors }) => (
                                <div className="grid gap-6">
                                    <div className="grid gap-2">
                                        <Label htmlFor="name">Username</Label>
                                        <Input
                                            id="name"
                                            type="text"
                                            name="name"
                                            required
                                            autoFocus
                                            tabIndex={1}
                                            autoComplete="username"
                                            placeholder="Username"
                                        />
                                        <InputError message={errors.name} />
                                    </div>

                                    <div className="grid gap-2">
                                        <Label htmlFor="phone">
                                            Phone number
                                        </Label>
                                        <Input
                                            id="phone"
                                            type="tel"
                                            name="phone"
                                            required
                                            tabIndex={2}
                                            autoComplete="tel"
                                            placeholder="+1 555 123 4567"
                                        />
                                        <InputError message={errors.phone} />
                                    </div>

                                    <Button
                                        type="submit"
                                        className="w-full"
                                        tabIndex={3}
                                        data-test="register-participant-button"
                                    >
                                        {processing && <Spinner />}
                                        Register
                                    </Button>
                                </div>
                            )}
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
