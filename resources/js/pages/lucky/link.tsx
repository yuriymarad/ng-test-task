import { Form, Head, router } from '@inertiajs/react';
import { CheckIcon, CopyIcon } from 'lucide-react';
import { useState } from 'react';
import AccessLinkController from '@/actions/App/Http/Controllers/AccessLinkController';
import LuckyDrawController from '@/actions/App/Http/Controllers/LuckyDrawController';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Spinner } from '@/components/ui/spinner';
import { useClipboard } from '@/hooks/use-clipboard';
import type { AccessLink, LuckyDraw, LuckyParticipant } from '@/types';

type Props = {
    participant: LuckyParticipant;
    link: AccessLink;
    lastDraw: LuckyDraw | null;
    history?: LuckyDraw[];
};

function formatAmount(amount: number): string {
    return amount.toFixed(2);
}

function formatDateTime(value: string): string {
    return new Date(value).toLocaleString();
}

function DrawResult({ draw }: { draw: LuckyDraw }) {
    return (
        <div className="flex flex-wrap items-center gap-x-6 gap-y-2">
            <div>
                <p className="text-sm text-muted-foreground">Number</p>
                <p className="text-2xl font-semibold">{draw.number}</p>
            </div>
            <div>
                <p className="text-sm text-muted-foreground">Result</p>
                <Badge
                    variant={draw.result === 'win' ? 'default' : 'secondary'}
                    className="mt-1"
                >
                    {draw.result === 'win' ? 'Win' : 'Lose'}
                </Badge>
            </div>
            <div>
                <p className="text-sm text-muted-foreground">Winning amount</p>
                <p className="text-2xl font-semibold">
                    {formatAmount(draw.amount)}
                </p>
            </div>
        </div>
    );
}

export default function LuckyLink({
    participant,
    link,
    lastDraw,
    history,
}: Props) {
    const [copiedText, copy] = useClipboard();
    const [loadingHistory, setLoadingHistory] = useState(false);

    const showHistory = () => {
        router.reload({
            only: ['history'],
            onStart: () => setLoadingHistory(true),
            onFinish: () => setLoadingHistory(false),
        });
    };

    return (
        <>
            <Head title="Your lucky page" />
            <div className="flex min-h-svh flex-col items-center bg-background p-6 md:p-10">
                <div className="flex w-full max-w-2xl flex-col gap-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Hi, {participant.name}</CardTitle>
                            <CardDescription>
                                This link works until{' '}
                                {formatDateTime(link.expiresAt)}.
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="flex flex-col gap-4">
                            <div className="flex gap-2">
                                <Input
                                    readOnly
                                    value={link.url}
                                    aria-label="Your unique link"
                                    onFocus={(event) =>
                                        event.currentTarget.select()
                                    }
                                />
                                <Button
                                    type="button"
                                    variant="outline"
                                    onClick={() => copy(link.url)}
                                    data-test="copy-link-button"
                                >
                                    {copiedText === link.url ? (
                                        <CheckIcon />
                                    ) : (
                                        <CopyIcon />
                                    )}
                                    Copy
                                </Button>
                            </div>

                            <div className="flex flex-wrap gap-2">
                                <Form
                                    {...AccessLinkController.regenerate.form(
                                        link.token,
                                    )}
                                    disableWhileProcessing
                                >
                                    {({ processing }) => (
                                        <Button
                                            type="submit"
                                            variant="outline"
                                            data-test="regenerate-link-button"
                                        >
                                            {processing && <Spinner />}
                                            Regenerate link
                                        </Button>
                                    )}
                                </Form>

                                <Form
                                    {...AccessLinkController.destroy.form(
                                        link.token,
                                    )}
                                    disableWhileProcessing
                                >
                                    {({ processing }) => (
                                        <Button
                                            type="submit"
                                            variant="destructive"
                                            data-test="deactivate-link-button"
                                        >
                                            {processing && <Spinner />}
                                            Deactivate link
                                        </Button>
                                    )}
                                </Form>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Feeling lucky?</CardTitle>
                            <CardDescription>
                                Draw a number between 1 and 1,000. Even numbers
                                win.
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="flex flex-col gap-4">
                            <div className="flex flex-wrap gap-2">
                                <Form
                                    {...LuckyDrawController.store.form(
                                        link.token,
                                    )}
                                    options={{ preserveScroll: true }}
                                    disableWhileProcessing
                                >
                                    {({ processing }) => (
                                        <Button
                                            type="submit"
                                            data-test="feeling-lucky-button"
                                        >
                                            {processing && <Spinner />}
                                            I'm Feeling Lucky
                                        </Button>
                                    )}
                                </Form>

                                <Button
                                    type="button"
                                    variant="outline"
                                    onClick={showHistory}
                                    disabled={loadingHistory}
                                    data-test="history-button"
                                >
                                    {loadingHistory && <Spinner />}
                                    History
                                </Button>
                            </div>

                            {lastDraw && (
                                <div
                                    className="rounded-lg border p-4"
                                    data-test="last-draw"
                                >
                                    <DrawResult draw={lastDraw} />
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    {history && (
                        <Card data-test="history">
                            <CardHeader>
                                <CardTitle>Last results</CardTitle>
                            </CardHeader>
                            <CardContent>
                                {history.length === 0 ? (
                                    <p className="text-sm text-muted-foreground">
                                        No results yet. Try your luck above.
                                    </p>
                                ) : (
                                    <ul className="flex flex-col divide-y">
                                        {history.map((draw, index) => (
                                            <li
                                                key={`${draw.createdAt}-${index}`}
                                                className="py-4 first:pt-0 last:pb-0"
                                            >
                                                <DrawResult draw={draw} />
                                                {draw.createdAt && (
                                                    <p className="mt-2 text-xs text-muted-foreground">
                                                        {formatDateTime(
                                                            draw.createdAt,
                                                        )}
                                                    </p>
                                                )}
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </CardContent>
                        </Card>
                    )}
                </div>
            </div>
        </>
    );
}
