import { useState, useEffect } from "react";
import axios from "axios";
import Flashcard from "./Flashcard";
import "../../css/style.css";

function App() {
    const [nameColors, setNameColors] = useState([]);
    const [error, setError] = useState(null);
    const [name, setName] = useState("");
    const [color, setColor] = useState("");
    const [words, setWords] = useState([]);
    const [view, setView] = useState("");
    const [editingId, setEditingId] = useState(null);
    const [editName, setEditName] = useState("");
    const [editColor, setEditColor] = useState("");
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (view === "nameColor") {
            fetchNameColors();
        } else if (view === "flashcard") {
            fetchWords();
        }
    }, [view]);

    const fetchNameColors = async () => {
        try {
            const response = await axios.get("/api/name-colors");
            setNameColors(response.data);
            setError(null);
        } catch (error) {
            setError("Failed to fetch entries");
        }
    };

    const fetchWords = async () => {
        try {
            setLoading(true); //Display loader
            const response = await axios.get("/api/words");
            setWords(response.data.words || []); // Handle case if response.data.words is undefined
            setError(null);
        } catch (error) {
            setError("Failed to fetch words");
        } finally {
            setLoading(false); //Hide loader
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post("/api/name-colors", { name, color });
            setName("");
            setColor("");
            fetchNameColors();
            setError(null);
        } catch (error) {
            setError("Failed to add entry");
        }
    };

    const startEditing = (item) => {
        setEditingId(item.id);
        setEditName(item.name);
        setEditColor(item.color);
    };

    const cancelEditing = () => {
        setEditingId(null);
        setEditName("");
        setEditColor("");
    };

    const saveEdit = async () => {
        try {
            await axios.put(`/api/name-colors/${editingId}`, {
                name: editName,
                color: editColor,
            });
            setEditingId(null);
            fetchNameColors();
            setError(null);
        } catch {
            setError("Failed to update entry");
        }
    };

    return (
        <div>
            <h1>Choose your view</h1>
            <div className="viewToggle">
                <button onClick={() => setView("nameColor")}>
                    Name Color View
                </button>
                <button onClick={() => setView("flashcard")}>
                    Flashcard View
                </button>
            </div>

            {view === "nameColor" && (
                <>
                    <form onSubmit={handleSubmit}>
                        <input
                            type="text"
                            placeholder="Name"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            required
                        />
                        <input
                            type="text"
                            placeholder="Color"
                            value={color}
                            onChange={(e) => setColor(e.target.value)}
                            required
                        />
                        <button type="submit">Add</button>
                    </form>

                    <ul>
                        {nameColors.map((item) => (
                            <li key={item.id}>
                                {editingId === item.id ? (
                                    <>
                                        <div className="editInputs">
                                            <input
                                                type="text"
                                                value={editName}
                                                onChange={(e) =>
                                                    setEditName(e.target.value)
                                                }
                                                placeholder="Edit name"
                                            />
                                            <input
                                                type="text"
                                                value={editColor}
                                                onChange={(e) =>
                                                    setEditColor(e.target.value)
                                                }
                                                placeholder="Edit color"
                                            />
                                        </div>
                                        <div className="editButtons">
                                            <button onClick={saveEdit}>
                                                Save
                                            </button>
                                            <button onClick={cancelEditing}>
                                                Cancel
                                            </button>
                                        </div>
                                    </>
                                ) : (
                                    <>
                                        {item.name} - {item.color}
                                        <div className="actionButtons">
                                            <button
                                                onClick={() =>
                                                    startEditing(item)
                                                }
                                            >
                                                Edit
                                            </button>
                                            <button
                                                onClick={() =>
                                                    handleDelete(item.id)
                                                }
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </>
                                )}
                            </li>
                        ))}
                    </ul>
                </>
            )}

            {error && <div className="errorMessage">{error}</div>}

            {view === "flashcard" && (
                <div className="flashcardContainer">
                    {loading ? (
                        <p className="loading"></p>
                    ) : error ? (
                        <p>{error}</p>
                    ) : words && words.length > 0 ? (
                        words.map((word) => (
                            <Flashcard
                                key={word.id}
                                word={word}
                                onFavoriteToggled={(id) => {
                                    setWords((prevWords) =>
                                        prevWords.map((word) =>
                                            word.id === id
                                                ? {
                                                      ...word,
                                                      isFavorite:
                                                          !word.isFavorite,
                                                  }
                                                : word
                                        )
                                    );
                                }}
                                onClose={(id) =>
                                    setWords((prev) =>
                                        prev.filter((word) => word.id !== id)
                                    )
                                }
                            />
                        ))
                    ) : (
                        <p className="flashcardError">
                            No flashcards to display
                        </p>
                    )}
                </div>
            )}
        </div>
    );
}

export default App;
