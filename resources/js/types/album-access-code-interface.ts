export interface AlbumAccessCodeInterface {
    id: number,
    albumId: number;
    accessCode: string;
    usages: number;
    saves: number;
}
