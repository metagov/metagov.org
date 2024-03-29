# -*- coding: utf-8 -*-
# Comma to Colon
# A script to turn a CSV file into a folder of Kirby CMS content files.
# Try Kirby for free: https://getkirby.com/
# Adapted from https://github.com/myleswrite/Comma-to-Colon
import regex as re

def filesafe(filename): # Create a Kirby safe filename
    safename = filename.replace(' ','-')
    safename = safename.replace('&','-')
    safename = safename.replace(',','-')
    safename = safename.replace('.','-')
    safename = safename.replace("'",'-')
    safename = safename.replace("%",'-')
    safename = safename.lower()
    return safename

try: # For importing the CSV module
    import csv
except:
    print("CSV module is required")
    exit()
try: # os required to create the individual folders
    import os
except:
    print('OS module is required')
    exit()
try: # For file dialog
    from tkinter import filedialog
    from tkinter import *
except:
    print("tkinter.filedialog is required")
    exit()

# Open the CSV
print("Select the CSV file to open using the file browser")
filecsv = Tk()
filecsv.filename = filedialog.askopenfilename(initialdir = "~/",title = "Select csv file to open",filetypes = (("CSV files","*.csv"),("all files","*.*")))
print ("Opening file " + filecsv.filename)
cn = input("What is the name of the Kirby blueprint being used (without the .yml extension)? ")
blueprint = cn + '.txt'
print("Select the folder to save files into using the file browser")
directory = filedialog.askdirectory(title = "Select where to save")
# Start work on the CSV file
sep = '\n\n----\n\n'
#markdown link regex pattern
linkpattern = re.compile(r'\[([^][]+)\](\(((?:[^()]+|(?2))+)\))')
with open(filecsv.filename, 'r') as f: # Open the file
    worklist = csv.DictReader(f)
    for row in worklist: # Turn each row into a Kirby content txt file
        line = ''
        try:
            title = row['title'] # title is the one heading that must be present
            filename = filesafe('20240118_'+title) + '/' + blueprint # Create a Kirby safe folder and use blueprint name
            print('Creating ' + filesafe(title) + '.txt')
        except:
            print("No 'title' item found so stopping. 'title' must be a heading and written in lowercase for the conversion to work.")
            exit()
        for val,item in row.items(): # Go through each column of each row in the CSV to create a Kirby file.
            if (val == 'Links'): # Parse links from markdown to kirby structure
                parsedlinks = "\n"
                for match in linkpattern.finditer(item):
                    description, _, url = match.groups()
                    print(f"{description}: {url}")
                    parsedlinks += f"  - \n  text: {description}\n  url: {url}"
                line += val + ': ' + parsedlinks + sep
            else: 
                line += val + ': ' + item + sep

        fullfile = directory + '/' + filename
        os.makedirs(os.path.dirname(fullfile), exist_ok=True)
        with open(fullfile,'w+') as sf: # Write the content txt file
            sf.write(line)
print("Finished")
exit()