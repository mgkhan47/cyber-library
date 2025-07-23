import requests
import json
import pandas as pd

# Your Google Books API key
API_KEY = "AIzaSyDZu5xexkEW_QdWM3Qwq2JsOdmWK*******"

# Function to fetch books based on the search query
def fetch_books(query, api_key, max_results=1000):
    book_details = []
    start_index = 0  # Initialize the startIndex for pagination
    books_per_request = 40  # Max 40 books per request from Google Books API

    while len(book_details) < max_results:
        # Build the API URL with pagination
        url = f"https://www.googleapis.com/books/v1/volumes?q={query}&startIndex={start_index}&maxResults={books_per_request}&key={api_key}"
        response = requests.get(url)

        if response.status_code == 200:
            books = response.json().get("items", [])
            for index, book in enumerate(books):
                volume_info = book.get("volumeInfo", {})
                title = volume_info.get("title", "No Title")
                authors = volume_info.get("authors", ["Unknown Author"])
                description = volume_info.get("description", "No Description")
                
                # Skip books with 'Unknown Author', 'No Description', or no ISBN
                if "Unknown Author" in authors or description == "No Description" or not any(identifier.get("type") == "ISBN_13" for identifier in volume_info.get("industryIdentifiers", [])):
                    continue

                # Extract ISBN (if available)
                isbn_list = volume_info.get("industryIdentifiers", [])
                isbn = ""
                for identifier in isbn_list:
                    if identifier.get("type") == "ISBN_13":
                        isbn = identifier.get("identifier", "No ISBN")
                        break

                # Extract volumeId and construct the URL
                volume_id = book.get("id", "")
                book_url = f"https://books.google.com/books?id={volume_id}" if volume_id else "No URL available"

                # Storing book details in a list
                book_details.append({
                    "Sr. No": len(book_details) + 1,
                    "Title": title,
                    "Authors": ", ".join(authors),
                    "Description": description,
                    "ISBN": isbn,
                    "URL": book_url
                })

            # Increment the startIndex to fetch the next page
            start_index += books_per_request

            # Stop if we have reached the desired number of books
            if len(book_details) >= max_results:
                break

        else:
            print(f"Error: {response.status_code}, {response.text}")
            break

    # Save books to a JSON file
    save_books_to_json(book_details)

    # Save books to an Excel file
    save_books_to_excel(book_details)

# Function to save book details to a JSON file
def save_books_to_json(books, filename="finalbook.json"):
    try:
        with open(filename, 'w', encoding='utf-8') as file:
            json.dump(books, file, ensure_ascii=False, indent=4)
        print(f"Books saved to {filename}")
    except Exception as e:
        print(f"Failed to save books: {e}")

# Function to save book details to an Excel file
def save_books_to_excel(books, filename="finalbook.xlsx"):
    try:
        # Convert book details to a pandas DataFrame
        df = pd.DataFrame(books)

        # Save to an Excel file
        df.to_excel(filename, index=False, engine='openpyxl')
        print(f"Books saved to {filename}")
    except Exception as e:
        print(f"Failed to save books to Excel: {e}")

# Main function to run the script
def main():
    query = "cyber security"  # You can change the search term here
    fetch_books(query, API_KEY, max_results=1000)

# Run the script
if __name__ == "__main__":
    main()
