import { useState } from "react";
import axios from "axios";
import "../../css/style.css";

function Flashcard({ word, onFavoriteToggled, onClose }) {
    const [flipped, setFlipped] = useState(false);
    const [error, setError] = useState(null);
    const [deleteError, setDeleteError] = useState(null);
    const [message, setMessage] = useState("");

    const handleToggleFavorite = async (e) => {
        e.stopPropagation();
        try {
            const response = await axios.post(`/api/words/${word.id}/favorite`);
            setMessage(response.data.message); //PHP message

            if (onFavoriteToggled) {
                onFavoriteToggled();
            }
        } catch (error) {
            setError("Failed to save favorite");
        }
    };

    const handleDelete = async () => {
        try {
            await axios.delete(`/api/words/${word.id}`);
            setMessage("Word deleted from favorites.");
            setTimeout(() => {
                if (onFavoriteToggled) {
                    onFavoriteToggled({ deletedId: word.id });
                }
                onClose && onClose(word.id);
            }, 1500);
            setError(null);
        } catch (error) {
            setDeleteError("Failed to delete: word was not saved as favorite.");
            setMessage(null);
        }
    };

    return (
        <div className="flashcard" onClick={() => setFlipped(!flipped)}>
            <button
                className="closeButton"
                onClick={(e) => {
                    e.stopPropagation();
                    onClose && onClose(word.id);
                }}
            >
                ×
            </button>

            {flipped ? (
                <div>
                    <h2>{word.finnish}</h2>
                    <h2>{word.english}</h2>
                    <h3>{word.example}</h3>
                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            handleToggleFavorite(e);
                        }}
                        className="favoriteButton"
                    >
                        Favorite
                    </button>

                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            handleDelete();
                        }}
                        className="deleteButton"
                    >
                        un-Favorite
                    </button>

                    {message && <div className="messageText">{message}</div>}
                    {error && <div className="deleteText">{error}</div>}
                    {deleteError && (
                        <div className="messageText">{deleteError}</div>
                    )}
                </div>
            ) : (
                <div>
                    <h2>{word.finnish}</h2>
                </div>
            )}
        </div>
    );
}

export default Flashcard;
