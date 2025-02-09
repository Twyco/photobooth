import {AlbumAccessCodeInterface} from "@/types/album-access-code-interface";

export interface AlbumInterface {
    id: number;
    uuid: string;
    title: string;
    slug: string;
    description: string;
    eventDate: string;
    accessCodes?: AlbumAccessCodeInterface[],
}
